<?php
declare(strict_types = 1);

namespace CargoExpress\Repositories;

use CargoExpress\Interfaces\Repositories\DeliveryContractsRepositoryInterface;
use CargoExpress\Models\Delivery\DeliveryContractModel;
use CargoExpress\Models\TransportModel;

class DeliveryContractsRepository implements DeliveryContractsRepositoryInterface
{
    protected $deliveryContracts = [];

    /**
     * Возвращает список договоров доставки для модели транспорта, в которых она занята в указанный период
     *
     * @param int $transportModelId
     * @param string $date
     * @return DeliveryContractModel[]
     */
    public function getForTransportModel(int $transportModelId, string $date): array {
        $result = [];

        /** @var DeliveryContractModel $deliveryContract */
        foreach ($this->deliveryContracts as $deliveryContract) {
            /** @var TransportModel $transportModel */
            $transportModel = $deliveryContract->getTransportModel();
            if ($transportModel->getId() === $transportModelId && $deliveryContract->getStartDate()) {
                $result[] = $deliveryContract;
            }
        }

        return $result;
    }
}