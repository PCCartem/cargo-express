<?php
declare(strict_types=1);

namespace CargoExpress\Repositories;

use CargoExpress\Interfaces\Repositories\PointRepositoryInterface;
use CargoExpress\Models\PointModel;
use Exception;

class PointRepository implements PointRepositoryInterface
{
    protected $points = [];

    /**
     * Возвращает пункт доставки по его id
     *
     * @param int $id
     * @return PointModel
     * @throws Exception
     */
    public function getById(int $id): PointModel
    {
        if (array_key_exists($id, $this->points)) {
            return $this->points[$id];
        }

        throw new Exception('Пункта доставки с таким id не существует в этом репозитории!');
    }

    /**
     * Возвращает пункт доставки по его имени
     *
     * @param string $name
     * @return PointModel
     * @throws Exception
     */
    public function getByName(string $name): PointModel
    {
        /** @var PointModel $point */
        foreach ($this->points as $point) {
            if ($point->getName() === $name) {
                return $point;
            }
        }

        throw new Exception('Пункта доставки с таким именем не существует в этом репозитории!');
    }

    /**
     *
     *
     * @param PointModel $point
     * @return bool
     * @throws Exception
     */
    public function save(PointModel $point) : bool
    {
        $this->points[$point->getId()] = $point;

        if (array_key_exists($point->getId(), $this->points)) {
            return true;
        }

        throw new Exception('Ошибка сохранения пункта доставки');
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->points;
    }
}