<?php
declare(strict_types = 1);

namespace CargoExpress\Models;

/**
 * Class TariffModel
 * @package CargoExpress\Models
 */
class TariffModel
{
    /** @var int id тарифа */
    protected $id;

    /** @var string имя тарифа */
    protected $name;

    /** @var float коэфицент тарифа */
    protected $coefficient;

    /**
     * PointModel constructor.
     * @param int $id
     * @param string $name
     * @param float $coefficient
     */
    public function __construct(int $id, string $name, float $coefficient)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->coefficient = $coefficient;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getCoefficient() : float
    {
        return $this->coefficient;
    }
}