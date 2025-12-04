<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
class UserNotification implements ShouldBroadcast
{
    use SerializesModels;

    public $payload;
    protected $userId;


    public function __construct(int $userId, array $payload)
    {
        $this->userId = $userId;
        $this->payload = $payload;
    }


    // 指定要广播到的私有频道（核心）
    public function broadcastOn()
    {
        // 返回的频道名必须与前端订阅的完全一致
        return new PrivateChannel('user.' . $this->userId);
    }


    // 自定义广播事件名（可选，但推荐）
    public function broadcastAs()
    {
        return 'UserNotification'; // 前端 .listen('UserNotification', ...) 监听的名称
    }

    // 自定义广播数据（可选，但推荐）
    public function broadcastWith()
    {
        return $this->payload; // 直接返回要推送的消息数组
    }



}
