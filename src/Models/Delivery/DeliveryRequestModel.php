<?php
declare(strict_types=1);

namespace CargoExpress\Models\Delivery;

class DeliveryRequestModel
{
    /** @var int id клиента */
    public $clientId;

    /** @var int id модели транспорта */
    public $transportModelId;

    /** @var int id пункта доставки */
    public $pointModelId;

    /** @var string дата получения груза у клиента */
    public $startDate;

    /** @var string */
    public $toAddress;

    /**
     * DeliveryRequestModel constructor.
     *
     * @param int $clientId
     * @param int $transportModelId
     * @param int $pointModelId
     * @param string $startDate
     * @param string $toAddress
     */
    public function __construct(
        int $clientId,
        int $transportModelId,
        int $pointModelId,
        string $startDate,
        string $toAddress
    ) {
        $this->clientId = $clientId;
        $this->transportModelId = $transportModelId;
        $this->startDate = $startDate;
        $this->toAddress = $toAddress;
        $this->pointModelId = $pointModelId;
    }
}