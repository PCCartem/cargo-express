<?php
declare(strict_types = 1);

namespace CargoExpress\Interfaces\Repositories;

use CargoExpress\Models\Delivery\DeliveryContractModel;

interface DeliveryContractsRepositoryInterface
{
    /**
     * Возвращает список договоров доставки для модели транспорта, в которых она занята в указанный период
     *
     * @param int $transportModelId
     * @param string $date
     * @return DeliveryContractModel[]
     */
    public function getForTransportModel(int $transportModelId, string $date): array;
}