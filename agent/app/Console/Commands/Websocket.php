<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Workerman\Websocket\Server;

class Websocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:websocket {action} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
        $action = $this->argument('action');
        if(!in_array($action, ['start','stop','reload','restart','status','connections'])){
            $this->error('Error Arguments');
            exit;
        }

        $argv[0] = 'workerman:websocket';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';
        Server::start();
    }
}
