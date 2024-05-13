<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Models\User;
use App\Notifications\CommonNotice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegisterEvent  $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $user = $event->user;
        if(blank($user)) return ;

        // 发送消息通知
        $user = User::query()->find($user['user_id']);
        $user->notify(new CommonNotice(['title'=>'注册成功','content'=>'注册成功']));
    }
}
