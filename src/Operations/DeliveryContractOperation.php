<?php
declare(strict_types=1);

namespace CargoExpress\Operations;

use CargoExpress\Models\Delivery\DeliveryContractModel;
use CargoExpress\Models\Delivery\DeliveryRequestModel;
use CargoExpress\Models\Delivery\DeliveryResponseModel;
use CargoExpress\Repositories\DeliveryContractsRepository;
use CargoExpress\Repositories\PointRepository;
use CargoExpress\Repositories\TransportRepository;
use CargoExpress\Repositories\ClientsRepository;
use Exception;

/**
 * Class DeliveryContractOperation
 * @package CargoExpress\Delivery
 */
class DeliveryContractOperation
{
    /** @var DeliveryContractsRepository */
    protected $contractsRepository;

    /** @var ClientsRepository */
    protected $clientsRepository;

    /** @var TransportRepository */
    protected $transportModelsRepository;

    /** @var PointRepository */
    protected $pointsModelsRepository;

    /**
     * DeliveryContractOperation constructor.
     *
     * @param DeliveryContractsRepository $contractsRepo
     * @param ClientsRepository $clientsRepo
     * @param TransportRepository $transportModelsRepo
     * @param PointRepository $pointsModelsRepo
     */
    public function __construct(
        DeliveryContractsRepository $contractsRepo,
        ClientsRepository $clientsRepo,
        TransportRepository $transportModelsRepo,
        PointRepository $pointsModelsRepo
    ) {
        $this->contractsRepository = $contractsRepo;
        $this->clientsRepository = $clientsRepo;
        $this->transportModelsRepository = $transportModelsRepo;
        $this->pointsModelsRepository = $pointsModelsRepo;
    }

    /**
     * @param DeliveryRequestModel $request
     * @return DeliveryResponseModel
     * @throws Exception
     */
    public function execute(DeliveryRequestModel $request): DeliveryResponseModel
    {
        $deliveryResponse = new DeliveryResponseModel();

        try {
            if (count($this->contractsRepository->getForTransportModel($request->transportModelId,
                    $request->startDate)) > 0) {
                throw new Exception('Извините Турбо Пушка занята ' . $request->startDate);
            }

            // Создание контакта
            $deliveryContract = new DeliveryContractModel(
                $this->clientsRepository->getById($request->clientId),
                $this->transportModelsRepository->getById($request->transportModelId),
                $this->pointsModelsRepository->getById($request->pointModelId),
                1,
                $request->startDate
            );

            $deliveryResponse->setDeliveryContract($deliveryContract);

            return $deliveryResponse;

        } catch (Exception $exception) {
            $deliveryResponse->pushError($exception->getMessage());
            return $deliveryResponse;
        }


    }
}