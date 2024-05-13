<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-10 17:01:01
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class CommonNotice extends Notification
{
    //通用通知

    use Queueable;

    private $notice;

    /**
     * Create a new notification instance.
     * @param array $notice
     * @return void
     */
    public function __construct(array $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $notice = $this->notice;
        return [
            'title' => $notice['title'],
            'content' => $notice['content'],
        ];
    }
    /**
     * @description: 将消息转化为多语言
     * @param {*}
     * @return {*}
     */
    public static function messageToMultilanguage($message)
    {
        $title = $message['title'];
        $content = $message['content'];
        return [
            'title' => __($message['title']), //获取标题
            'content' => __($message['content']), //获取内容
        ];
    }
}
