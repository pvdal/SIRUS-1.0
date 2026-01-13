<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedNotifyCommitteeMembers extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $committee;
    protected string $group;

    public function __construct($committee, $group)
    {
        $this->committee = $committee;
        $this->group = $group;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Convite para participação em banca avaliadora')
            ->greeting('Olá, ' . $notifiable->name)
            ->line(
                'Você foi convidado(a) a participar da banca avaliadora **' .
                $this->committee . '**, responsável pela avaliação do grupo **' .
                $this->group . '**.'
            )
            ->line('O trabalho escrito em formato **PDF** já está disponível para leitura.')
            ->line(
                'As **datas** e **horários** das avaliações serão divulgados em breve. ' .
                'Recomendamos acompanhar a agenda pelo sistema.'
            )
            ->action('Acessar SIRUS', url('/login'))
            ->line('Contamos com sua participação.');

    }
}
