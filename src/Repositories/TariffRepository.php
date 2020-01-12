<?php
declare(strict_types=1);

namespace CargoExpress\Repositories;

use CargoExpress\Interfaces\Repositories\TariffRepositoryInterface;
use CargoExpress\Models\TariffModel;
use Exception;

class TariffRepository implements TariffRepositoryInterface
{
    protected $tariff = [];

    /**
     * Возвращает пункт доставки по его id
     *
     * @param int $id
     * @return TariffModel
     * @throws Exception
     */
    public function getById(int $id): TariffModel
    {
        if (array_key_exists($id, $this->tariff)) {
            return $this->tariff[$id];
        }

        throw new Exception('Пункта доставки с таким id не существует в этом репозитории!');
    }

    /**
     *
     *
     * @param TariffModel $point
     * @return bool
     * @throws Exception
     */
    public function save(TariffModel $point) : bool
    {
        $this->tariff[$point->getId()] = $point;

        if (array_key_exists($point->getId(), $this->tariff)) {
            return true;
        }

        throw new Exception('Ошибка сохранения пункта доставки');
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->tariff;
    }
}