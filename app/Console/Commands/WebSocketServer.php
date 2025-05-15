<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSockets\OrderAnalyticsServer;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:serve';
    protected $description = 'Run Ratchet WebSocket Server';

    protected static $serverInstance;

    public function handle()
    {
        $port = 8080;
        $this->info("Starting WebSocket server on port {$port}");
        

        self::$serverInstance = new OrderAnalyticsServer();

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    self::$serverInstance
                )
            ),
            $port
        );

        $server->run();
    }

    // Static method to get server instance (optional for integration)
    public static function getServerInstance()
    {
        return self::$serverInstance;
    }
}
