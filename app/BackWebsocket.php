<?php

namespace App;


use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/** Чат - серверная часть */
class Chat implements MessageComponentInterface
{
    private \SplObjectStorage $clients;           // хранение всех подключенных пользователей

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn); // добавление клиента
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "error: {$e->getMessage()}\n";
        $conn->close();
    }
}
