<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
  use Queueable;

  public $token;
  public $email;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($token, $email)
  {
    $this->token = $token;
    $this->email = $email;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $url = route('admin.password.reset', ['token' => $this->token, 'email' => $this->email]);
    return (new MailMessage)
      ->subject(env('APP_NAME', 'Laravel') . ' : Password Reset')
      ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
      ->markdown('content.passwords.admin-reset-email', ['url' => $url]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
