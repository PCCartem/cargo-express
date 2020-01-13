<?php
declare(strict_types = 1);

namespace CargoExpress\Delivery;

use CargoExpress\Models\Delivery\DeliveryContractModel;
use CargoExpress\Models\Delivery\DeliveryRequestModel;
use CargoExpress\Models\PointModel;
use CargoExpress\Operations\DeliveryContractOperation;
use CargoExpress\Repositories\DeliveryContractsRepository;
use CargoExpress\Repositories\PointRepository;
use CargoExpress\Repositories\TransportRepository;
use CargoExpress\Repositories\ClientsRepository;
use CargoExpress\Models\TransportModel;
use CargoExpress\Models\ClientModel;
use PHPUnit\Framework\TestCase;
use Exception;

class DeliveryContractOperationTest extends TestCase
{
    /**
     * @param mixed ...$clients
     * @return ClientsRepository
     * @throws Exception
     */
    private function makeFakeClientRepository(...$clients): ClientsRepository
    {
        /** @var ClientsRepository $clientsRepository */
        $clientsRepository = new ClientsRepository();
        foreach ($clients as $client) {
            $clientsRepository->save($client);
        }

        return $clientsRepository;
    }

    /**
     * @param mixed ...$points
     * @return PointRepository
     * @throws Exception
     */
    private function makeFakePointRepository(...$points): PointRepository
    {
        /** @var PointRepository $pointsRepository */
        $pointsRepository = new PointRepository();
        foreach ($points as $point) {
            $pointsRepository->save($point);
        }

        return $pointsRepository;
    }

    /**
     * Stub репозитория моделей транспорта
     *
     * @param TransportModel[] ...$transportModels
     * @return TransportRepository
     */
    private function makeFakeTransportModelRepository(...$transportModels): TransportRepository
    {
        $transportModelsRepository = $this->prophesize(TransportRepository::class);
        foreach ($transportModels as $transportModel) {
            $transportModelsRepository->getById($transportModel->getId())->willReturn($transportModel);
        }

        return $transportModelsRepository->reveal();
    }

    /**
     * Если транспорт занят, то нельзя его арендовать
     */
    public function test_periodIsBusy_failedWithOverlapInfo()
    {
        // -- Arrange
        {
            // Клиенты
            $client1    = new ClientModel(1, 'Джонни');
            $client2    = new ClientModel(2, 'Роберт');
            $clientRepo = $this->makeFakeClientRepository($client1, $client2);

            // Модель транспорта
            $transportModel1 = new TransportModel(1, 'Турбо Пушка', 20, 20);

            //Пункт доставки и репозиторий
            $point1 = new PointModel(1, 'Нью-Йорк', 250);
            $pointModelsRepository = $this->makeFakePointRepository($point1);

            $transportModelsRepo = $this->makeFakeTransportModelRepository($transportModel1);

            // Контракт доставки. 1й клиент арендовал транпорт 1
            /** @var DeliveryContractModel $deliveryContract */
            $deliveryContract = new DeliveryContractModel($client1, $transportModel1, $point1, 1, '2020-01-03 00:00');

            // Stub репозитория договоров
            /** @var DeliveryContractsRepository $contractsRepo */
            $contractsRepo = $this->prophesize(DeliveryContractsRepository::class);
            $contractsRepo
                ->getForTransportModel($transportModel1->getId(), '2020-01-01 10:00')
                ->willReturn([ $deliveryContract ]);

            // Запрос на новую доставку. 2й клиент выбрал время когда транспорт занят.
            /** @var DeliveryRequestModel $deliveryRequest */
            $deliveryRequest = new DeliveryRequestModel($client2->getId(), $transportModel1->getId(), $point1->getId(), '2020-01-01 10:00', 'Нью-Йорк');

            // Операция заключения договора на доставку
            $deliveryContractOperation = new DeliveryContractOperation($contractsRepo->reveal(), $clientRepo, $transportModelsRepo, $pointModelsRepository);
        }

        // -- Act
        $response = $deliveryContractOperation->execute($deliveryRequest);

        // -- Assert
        $this->assertCount(1, $response->getErrors());

        $message = 'Извините Турбо Пушка занята 2020-01-01 10:00';
        $this->assertStringContainsString($message, $response->getErrors()[0]);
    }

    /**
     * Если транспорт свободен, то его легко можно арендовать
     */
    public function test_successfullyOperation()
    {
        // -- Arrange
        {
            // Клиент
            $client1    = new ClientModel(1, 'Джонни');
            $clientRepo = $this->makeFakeClientRepository($client1);

            // Модель транспорта
            $transportModel1    = new TransportModel(1, 'Турбо Пушка', 20, 20);
            $transportModelRepo = $this->makeFakeTransportModelRepository($transportModel1);

            //Пункт доставки и репозиторий
            $point1 = new PointModel(1, 'Нью-Йорк', 250);
            $pointModelsRepository = $this->makeFakePointRepository($point1);

            $tariffsRepo = $this->prophesize(Tari::class);

            $contractsRepo = $this->prophesize(DeliveryContractsRepository::class);
            $contractsRepo
                ->getForTransportModel($transportModel1->getId(), '2020-01-01 10:00')
                ->willReturn([]);

            // Запрос на новую доставку
            $deliveryRequest = new DeliveryRequestModel($client1->getId(), $transportModel1->getId(), $point1->getId(), '2020-01-01 10:00', 'Нью-Йорк');


            // Операция заключения договора на доставку
            $deliveryContractOperation = new DeliveryContractOperation($contractsRepo->reveal(), $clientRepo, $transportModelRepo, $pointModelsRepository);
        }

        // -- Act
        $response = $deliveryContractOperation->execute($deliveryRequest);

        // -- Assert
        $this->assertEmpty($response->getErrors());
        $this->assertInstanceOf(DeliveryContractModel::class, $response->getDeliveryContract());

        $this->assertEquals(5000, $response->getDeliveryContract()->getPrice());
    }
}