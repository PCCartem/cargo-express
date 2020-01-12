<?php
declare(strict_types=1);

namespace CargoExpress\Models;

class TransportModel
{
    /** @var int id модели транспорта */
    protected $id;

    /** @var string название модели транспорта */
    protected $name;

    /** @var float Стоимость модели транспорта за час килеметр движения */
    protected $pricePerKilometer;

    /** @var float Это средняя скорость с учетом всех остановок, я сделал так потому что не хотел составлять график маршрута c отдыхом водителя или дозаправкой */
    protected $averageSpeed;

    /**
     * TransportModel constructor.
     *
     * @param int $id
     * @param string $name
     * @param float $pricePerHour
     * @param float $averageSpeed
     */
    public function __construct(int $id, string $name, float $pricePerHour, float $averageSpeed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pricePerKilometer = $pricePerHour;
        $this->averageSpeed = $averageSpeed;
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
    public function getPricePerKilometer(): float
    {
        return $this->pricePerKilometer;
    }

    /**
     * @return float
     */
    public function getAverageSpeed(): float
    {
        return $this->averageSpeed;
    }
}