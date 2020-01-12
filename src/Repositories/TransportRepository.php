<?php
declare(strict_types=1);

namespace CargoExpress\Repositories;

use CargoExpress\Interfaces\Repositories\TransportRepositoryInterface;
use CargoExpress\Models\TransportModel;

class TransportRepository implements TransportRepositoryInterface
{
    protected $transports = [];

    /**
     * Возвращает транспорт по его id
     *
     * @param int $id
     * @return TransportModel
     * @throws \Exception
     */
    public function getById(int $id): TransportModel
    {
        if (array_key_exists($id, $this->transports)) {
            return $this->transports[$id];
        }

        throw new \Exception('Транспорта с таким id не существует в этом репозитории!');
    }

    /**
     * Сохраняет трансморт в репозитории
     *
     * @param TransportModel $transport
     * @return bool
     * @throws
     */
    public function save(TransportModel $transport): bool
    {
        $this->transports[$transport->getId()] = $transport;

        if (array_key_exists($transport->getId(), $this->transports)) {
            return true;
        }

        throw new \Exception('Ошибка сохранения клиента');
    }

    /**
     * Возвращает весь транспорт репозитория
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->transports;
    }
}