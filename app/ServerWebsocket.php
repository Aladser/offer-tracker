<?php

namespace App;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\Http\Controllers\OfferController;

/** Чат - серверная часть */
class ServerWebsocket implements MessageComponentInterface
{
    private \SplObjectStorage $clients;           // хранение всех подключенных пользователей
    private OfferController $offerCtl;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->offerCtl = new OfferController();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn); // добавление клиента
        echo "cоединение установлено\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "cоединение закрыто\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);

        if ($data->type === 'ADDING_NEW_OFFER') {
            echo 'добавление оффера:' . json_encode($this->offerCtl->store($data)) . "\n";
        } else {
            echo "Получено сообщение: $msg\n";
        }

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }
}
