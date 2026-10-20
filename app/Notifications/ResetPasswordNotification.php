<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:4200');
        $url = "{$frontendUrl}/resetar-senha/{$this->token}?email={$notifiable->getEmailForPasswordReset()}";

        return (new MailMessage)
            ->subject('Eco Saúde - Recuperação de Senha')
            ->greeting("Olá, {$notifiable->name}!")
            ->line('Recebemos uma solicitação para redefinir a sua senha de acesso ao **Eco Saúde**.')
            ->action('Redefinir Minha Senha', $url)
            ->line('Este link para redefinição é válido por ' . config('auth.passwords.users.expire') . ' minutos.')
            ->line('Se você não fez esta solicitação, por favor ignore este e-mail.');
    }
}