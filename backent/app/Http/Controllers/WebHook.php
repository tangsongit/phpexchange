<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WebHook extends Controller
{

    public function deploy(Request $request)
    {
        $path = base_path();
        $log_path = "{$path}/storage/logs/git.log";
        $time_string = "\"[" . Carbon::now()->toDateTimeString() . "]\"";

        // $token = 'd1oIyDm6zVkPaELSD3gyMigNtfjqS5kpzbLoLMviJ1nKWNky';
        // $params = $request->all();
        // if (empty($params['token']) || $params['token'] !== $token) {
        //     exit('error request');
        // }
        shell_exec("echo {$time_string} >> {$log_path}"); //记录执行时间
        shell_exec("cd $path && git pull  >> {$log_path}"); //执行更新命令
        return json_encode(['code' => 1]);
    }
}
