<?php
declare(strict_types = 1);

namespace CargoExpress\Interfaces\Repositories;

use CargoExpress\Models\PointModel;

interface PointRepositoryInterface
{
    /**
     * Возвращает пункт доставки по его id
     *
     * @param int $id
     * @return PointModel
     */
    public function getById(int $id): PointModel;

    /**
     * Сохраняет пункт доставки в репозитории
     *
     * @param PointModel $point
     * @return bool
     */
    public function save(PointModel $point): bool;

    /**
     * Возвращает все пункты доставки репозитория
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Возвращает все пункты доставки репозитория
     *
     * @return array
     */
    public function getByName(): array;
}