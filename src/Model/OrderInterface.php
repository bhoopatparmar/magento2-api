<?php
declare(strict_types=1);

namespace Salecto\Magento2Api\Model;

/**
 * Interface OrderInterface
 */
interface OrderInterface
{
    /**
     * Get orders by Integration ID.
     *
     * @param string $integrationId
     * @param string $searchCriteria
     * @return array|string
     * @throws \Exception
     */
    public function getOrdersByIntegrationId(string $integrationId, string $searchCriteria = '');

    /**
     * Synchronize order by Integration ID and Order ID.
     *
     * @param string $integrationId
     * @param string $orderId
     * @return array|string
     * @throws \Exception
     */
    public function syncOrders(string $integrationId, string $orderId);
}
