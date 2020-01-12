<?php
declare(strict_types = 1);

namespace CargoExpress\Models\Delivery;

use CargoExpress\Models\PointModel;
use CargoExpress\Models\TransportModel;
use CargoExpress\Models\ClientModel;
use Exception;

class DeliveryContractModel
{
    /** @var float Стоимость */
    protected $price = 0;

    /** @var ClientModel */
    protected $clientModel;

    /** @var PointModel */
    protected $pointModel;

    /** @var TransportModel */
    protected $transportModel;

    /** @var string */
    protected $startDate;

    /** @var string */
    protected $deliveryDate;

    /** @var string */
    protected $endDate;

    /**
     * DeliveryContractModel constructor.
     *
     * @param ClientModel $client
     * @param TransportModel $transport
     * @param PointModel $point
     * @param int $tariff
     * @param string $startDate
     * @throws Exception
     */
    public function __construct(ClientModel $client, TransportModel $transport, PointModel $point, int $tariff, string $startDate)
    {
        $this->transportModel = $transport;
        $this->startDate = $startDate;
        $this->clientModel = $client;
        $this->pointModel = $point;

        // Расчет цены
        $pricePerKm = $transport->getPricePerKilometer();
        $distance = $point->getDistance();
        $averageSpeed = $transport->getAverageSpeed();

        $this->price = $pricePerKm * $distance * $tariff;

        $this->calculateDeliveryDates($startDate, $averageSpeed, $distance);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return bool
     */
    public function setPrice(float $price): bool
    {
        $this->price = $price;

        return true;
    }

    /**
     * @return TransportModel
     */
    public function getTransportModel()
    {
        return $this->transportModel;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param $startDate
     * @param $averageSpeed
     * @param $distance
     * @return bool
     * @throws Exception
     */
    protected function calculateDeliveryDates($startDate, $averageSpeed, $distance)
    {
        $hoursOnTheRoad = ceil($distance / $averageSpeed);

        $this->deliveryDate = (new \DateTime($startDate))->modify('+'.$hoursOnTheRoad.' hour')->format("Y-m-d H:i:s");

        $this->endDate = (new \DateTime($this->deliveryDate))->modify('+'.$hoursOnTheRoad.' hour')->format("Y-m-d H:i:s");

        return true;
    }
}
