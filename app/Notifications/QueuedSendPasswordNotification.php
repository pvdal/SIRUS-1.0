<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedSendPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Sua senha temporária')
            ->greeting('Olá ' . $notifiable->name)
            ->line('Sua conta foi criada com sucesso.')
            ->line('Sua senha temporária é: ' . $this->password)
            ->action('Acessar SIRUS', url('/login'))
            ->line('Caso não tenha criado nenhuma conta, ignore este e-mail.')
            ->line('Obrigado por usar o SIRUS!');
    }
}
