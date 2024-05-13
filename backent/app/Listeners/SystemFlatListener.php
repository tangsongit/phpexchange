<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-10 16:57:52
 */

namespace App\Listeners;

use App\Events\SystemFlatEvent;
use App\Models\User;
use App\Notifications\CommonNotice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SystemFlatListener
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
     * @param  SystemFlatEvent  $event
     * @return void
     */
    public function handle(SystemFlatEvent $event)
    {
        $user = User::query()->find($event->user_id);
        $body = [
            'title' => '爆仓强平',
            'content' => '爆仓强平',
        ];
        $user->notify(new CommonNotice($body));
    }
}
