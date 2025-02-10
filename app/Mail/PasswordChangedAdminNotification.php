<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangedAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $time;
    public $ip;

    public function __construct($user, $time, $ip)
    {
        $this->user = $user;
        $this->time = $time;
        $this->ip = $ip;
    }

    public function build()
    {
        return $this->subject('Notificación de Cambio de Contraseña')
                    ->view('emails.password_changed_admin')
                    ->with([
                        'username' => $this->user->name,
                        'email' => $this->user->email,
                        'time' => $this->time->format('d/m/Y H:i:s'),
                        'ip' => $this->ip,
                    ]);
    }
}
