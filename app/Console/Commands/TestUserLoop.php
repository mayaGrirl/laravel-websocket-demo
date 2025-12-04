<?php

namespace App\Console\Commands;

use App\Events\UserNotification;
use Illuminate\Console\Command;

class TestUserLoop extends Command
{

    //要执行的command:php artisan test:push-loop 1
    //配合执行的消息队列：php artisan queue:work
    /**
     * Execute the console command.
     */
    protected $signature = 'test:push-loop {user_id}';
    protected $description = '持续推送测试数据';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $this->info("开始给用户 {$userId} 持续推送消息... (Ctrl+C 停止)");

        $counter = 1;
        while (true) {
            $message = ['msg' => "后台推送消息测试 #{$counter} ", 'time' => now()];
            event(new UserNotification($userId, $message));

            $this->info("已推送: " . json_encode($message));
            $counter++;
            sleep(3); // 每 3 秒推送一次
        }
    }
}
