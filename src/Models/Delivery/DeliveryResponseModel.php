<?php
declare(strict_types = 1);

namespace CargoExpress\Models\Delivery;

class DeliveryResponseModel
{
    /** @var DeliveryContractModel контракт доставки */
    protected $deliveryContract;

    /** @var string[] список ошибок */
    protected $errors = [];

    /**
     * @return DeliveryContractModel
     */
    public function getDeliveryContract(): ?DeliveryContractModel
    {
        return $this->deliveryContract;
    }

    /**
     * @param DeliveryContractModel $deliveryContract
     */
    public function setDeliveryContract(DeliveryContractModel $deliveryContract)
    {
        $this->deliveryContract = $deliveryContract;
    }

    /**
     * @param string $error
     */
    public function pushError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}