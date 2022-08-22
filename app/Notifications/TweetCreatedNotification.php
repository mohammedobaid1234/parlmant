<?php

namespace App\Notifications;

use App\Models\Tweet;
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

class TweetCreatedNotification extends Notification
{
    use Queueable;

    protected $tweet;
    protected $user;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
        $this->user = User::where('id', $tweet->user_id)->firstOrFail();
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
            'title' => 'غرد' . $this->user->name . ' ' . 'حديثا',
            'url' => config('app.url') . "/api/tweets/" . $this->tweet->id,
            'icon' =>$this->user->image_path,
            'created_at' => date('Y-m-d H:i:s.uZ')
        ];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['url' => config('app.url') . "/api/tweets/" . $this->tweet->id])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Account Activated')
                
                ->setBody('غرد' . $this->user->name . ' ' . 'حديثا')
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
