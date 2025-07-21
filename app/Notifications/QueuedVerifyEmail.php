<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedVerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    use Queueable;
    // Nada a mais precisa aqui, estamos apenas enfileirando a notificação padrão
}
