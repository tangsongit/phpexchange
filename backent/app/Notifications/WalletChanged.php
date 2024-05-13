<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-10 16:49:15
 */
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:28
 */

namespace App\Notifications;

use App\Models\UserWallet;
use App\Models\UserWalletLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;


use Illuminate\Http\Request;


class WalletChanged extends Notification
{
    use Queueable;

    private $params;

    /**
     * Create a new notification instance.
     * @param array $params
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
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
    public function toArray_copy($notifiable)
    {
        return [
            'title' => $this->params['coin_name'] . '资产' . $this->params['change_type'],
            'content' => UserWalletLog::$logType[$this->params['log_type']] . '：' . $this->params['coin_name'] . '资产' . $this->params['change_type'] . $this->params['amount'],
        ];
    }

    public function toArray($notifiable)
    {
        //        $lang = App::getLocale();
        $lang = 'zh-CN';

        $title = $this->params['coin_name'] . ' 资产' . __($this->params['change_type'], [], $lang);
        //        $title = baiduTransAPI($title, 'auto', $lang);

        $content = __(UserWalletLog::$logType[$this->params['log_type']], [], $lang) . '：' . $this->params['coin_name'] . ' 资产' . __($this->params['change_type'], [], $lang) . ' ' . $this->params['amount'];
        //        $content = baiduTransAPI($content, 'auto', $lang);

        return [
            'title' => $title,
            'content' => $content,
        ];
    }

    /**
     * @description: 将消息转化为多语言
     * @param {*}
     * @return {*}
     */
    public static function messageToMultilanguage($message)
    {
        $title = $message['title']; //获取标题
        $content = $message['content']; //获取内容
        return [
            'title' => implode(" ", collect(explode(" ", $title, 2))->map(function ($v, $k) {
                if ($k != 0) {
                    return __($v);
                }
                return $v;
            })->toArray()),
            'content' => implode("：", collect(explode("：", $content))->map(function ($v, $k) {
                if ($k == 0) {
                    return __($v);
                }
                if ($k == 1) {
                    return implode("", collect(explode(" ", $v))->map(function ($v, $k) {
                        if ($k == 1) {
                            return " " . __($v) . " ";
                        }
                        return $v;
                    })->toArray());
                }
            })->toArray())
        ];
    }
}
