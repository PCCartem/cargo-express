<?php
declare(strict_types = 1);

namespace CargoExpress\Interfaces\Repositories;

use CargoExpress\Models\ClientModel;

interface ClientsRepositoryInterface
{
    /**
     * Возвращает клиента по его id
     *
     * @param int $id
     * @return ClientModel
     */
    public function getById(int $id): ClientModel;

    /**
     * Сохраняет клиента в репозитории
     *
     * @param ClientModel $client
     * @return bool
     */
    public function save(ClientModel $client): bool;

    /**
     * Возвращает всех клиентов репозитория
     *
     * @return array
     */
    public function getAll(): array;
}