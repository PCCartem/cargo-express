<?php
declare(strict_types = 1);

namespace CargoExpress\Interfaces\Repositories;

use CargoExpress\Models\TransportModel;

interface TransportRepositoryInterface
{
    /**
     * Возвращает транспорт по его id
     *
     * @param int $id
     * @return TransportModel
     */
    public function getById(int $id): TransportModel;

    /**
     * Сохраняет трансморт в репозитории
     *
     * @param TransportModel $point
     * @return bool
     */
    public function save(TransportModel $point): bool;

    /**
     * Возвращает весь транспорт репозитория
     *
     * @return array
     */
    public function getAll(): array;
}