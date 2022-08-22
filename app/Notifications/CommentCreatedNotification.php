<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->user = User::where('id', $comment->user_id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database', 
            FcmChannel::class
    ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'علق ' . $this->user->name . ' ' . 'على تغريدتك',
            'url' => config('app.url') . "/api/tweets/" . $this->comment->id,
            'icon' =>$this->user->image_path,
            'created_at' => date('Y-m-d H:i:s.uZ')
        ];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['url' => config('app.url') . "/api/tweets/" . $this->comment->id])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Notification')
                ->setBody('علق ' . $this->user->name . ' ' . 'على تغريدتك')
                ->setImage('https://matjr.host/uploads/logo2.jpeg'))
            // ->setAndroid(
            //     AndroidConfig::create()
            //         ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
            //         ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            // )
            ->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
