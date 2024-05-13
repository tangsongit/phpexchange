<?php

namespace App\Jobs\Timer\Spot;

use App\Jobs\Timer\Spot\Common;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;

class IndexMarketList extends Common
{
    public function run()
    {
        $data = self::getMarketList();
        $group_id2 = 'indexMarketList';
        $group_id3 = 'exchangeMarketList';
        $message2 = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id2]);
        $message3 = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id3]);
        WebsocketGroup::sendToGroup($group_id2, $message2);
        WebsocketGroup::sendToGroup($group_id3, $message3);
    }
}
