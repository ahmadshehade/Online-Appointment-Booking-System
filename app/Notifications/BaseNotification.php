<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected ?string $url;
    protected array $data;
    protected array $channels;


    /**
     * Summary of __construct
     * @param string $title
     * @param string $message
     * @param mixed $url
     * @param array $data
     * @param array $channels
     */
    public function __construct(
        string $title,
        string $message,
        ?string $url = null,
        array $data = [],
        array $channels = ['mail', 'database']
    ) {
        $this->title    = $title;
        $this->message  = $message;
        $this->url      = $url;
        $this->data     = $data;
        $this->channels = $channels;
    }

    public function via($notifiable): array
    {
        return $this->channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title) 
            ->greeting('Hello ' . $notifiable->name . ',') 
            ->line($this->message) // your custom message
            ->line('If you have any questions, please contact support.') 
            ->when($this->url, function (MailMessage $mail) {
                $mail->action('View Details', $this->url);
            });
    }


    public function toDatabase($notifiable): array
    {
        return array_merge([
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
        ], $this->data);
    }

    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
