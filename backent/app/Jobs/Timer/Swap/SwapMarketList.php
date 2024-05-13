<?php

namespace App\Jobs\Timer\Swap;

use App\Jobs\Timer\Swap\Common;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;

class SwapMarketList extends Common
{
    public function run()
    {
        $data = self::getMarketList();
        $group_id = 'swapMarketList';
        $message3 = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
        WebsocketGroup::sendToGroup($group_id, $message3);
    }
}
