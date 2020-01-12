<?php
declare(strict_types=1);

namespace CargoExpress\Repositories;

use CargoExpress\Models\ClientModel;
use CargoExpress\Interfaces\Repositories\ClientsRepositoryInterface;
use Exception;

class ClientsRepository implements ClientsRepositoryInterface
{
    /** @var array Список клиентов */
    protected $clients = [];

    /**
     * Возвращает клиента по его id
     *
     * @param int $id
     * @return ClientModel
     * @throws Exception
     */
    public function getById(int $id): ClientModel
    {
        if (array_key_exists($id, $this->clients)) {
            return $this->clients[$id];
        }

        throw new Exception('Клиента с таким id не существует в этом репозитории!');
    }

    /**
     * @param ClientModel $client
     * @return bool
     * @throws Exception
     */
    public function save(ClientModel $client) : bool
    {
        $this->clients[$client->getId()] = $client;

        if (array_key_exists($client->getId(), $this->clients)) {
            return true;
        }

        throw new Exception('Ошибка сохранения клиента');
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->clients;
    }
}