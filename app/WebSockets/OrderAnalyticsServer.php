<?php

namespace App\WebSockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\Factory as LoopFactory;
use React\Redis\Factory as RedisFactory;

class OrderAnalyticsServer implements MessageComponentInterface
{
    protected $clients;
    protected $loop;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->loop = LoopFactory::create();

        // Setup Redis subscriber inside ReactPHP event loop
        $this->setupRedisSubscriber();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Optional: handle incoming messages if needed
        echo "Received message: $msg\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    // Broadcast a message to all connected clients
    protected function broadcastMessage(string $type, $data)
    {
        $msg = json_encode(['type' => $type, 'data' => $data]);
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function broadcastNewOrder($orderData)
    {
        $this->broadcastMessage('new_order', $orderData);
    }

    public function broadcastAnalyticsUpdate($analyticsData)
    {
        $this->broadcastMessage('analytics_update', $analyticsData);
    }

    protected function setupRedisSubscriber()
    {
        $redisFactory = new RedisFactory($this->loop);
        $redisFactory->createSubscriber('redis://localhost:6379')->then(function ($subscriber) {
            $subscriber->subscribe('orders-channel');

            $subscriber->on('message', function ($channel, $message) {
                echo "Redis message on channel {$channel}: {$message}\n";
                // Forward Redis message to all WebSocket clients
                foreach ($this->clients as $client) {
                    $client->send($message);
                }
            });
        });
    }

    // Run the Ratchet server with ReactPHP event loop integrated
    public function runServer($port = 8080)
    {
        $server = \Ratchet\Server\IoServer::factory(
            new \Ratchet\Http\HttpServer(
                new \Ratchet\WebSocket\WsServer($this)
            ),
            $port,
            '0.0.0.0',
            $this->loop
        );

        echo "WebSocket server started on port {$port}\n";

        $this->loop->run();
    }
}
