<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;


class SendNotification extends Notification
{
    use Queueable;

    protected $content;
    protected $type;
    protected $filename;
    protected $filetype;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $type, $content, $fileName = null, $fileType = null)
    {
        if ($type = 'file' and !($fileType or $fileName)) {
            throw new \ErrorException('Notification with type - file must contain filetype(pdf, mp3  etc) and filename');
        }
        $this->type = $type;
        $this->content = $content;
        $this->filetype = $fileType;
        $this->filename = $fileName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['telegram'];
    }
    public function toTelegram($notifiable)
    {
        $to = env('TELEGRAM_GROUP_ID', '');
        if (!$to) {
            throw new \ErrorException('TELEGRAM_GROUP_ID env variable can\' be empty');
        }
        $content = $this->content;

        if ($this->type === 'text') {
            return TelegramMessage::create()
                ->to($to)
                ->content($content);
        } elseif ($this->type === 'file') {
            return TelegramFile::create()
                ->to($to)
                ->file($content, $this->filetype, $this->filename);
        }
    }
}