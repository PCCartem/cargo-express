<?php
declare(strict_types = 1);

namespace CargoExpress\Interfaces\Repositories;

use CargoExpress\Models\TariffModel;

interface TariffRepositoryInterface
{
    /**
     * Возвращает пункт доставки по его id
     *
     * @param int $id
     * @return TariffModel
     */
    public function getById(int $id): TariffModel;

    /**
     * Сохраняет клиента в репозитории
     *
     * @param TariffModel $point
     * @return bool
     */
    public function save(TariffModel $point): bool;

    /**
     * Возвращает все пункты доставки репозитория
     *
     * @return array
     */
    public function getAll(): array;
}