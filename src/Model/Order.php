<?php
declare(strict_types=1);

namespace Salecto\Magento2Api\Model;

use Salecto\Magento2Api\Service\RestApi;

class Order implements OrderInterface
{
    /**
     * @var RestApi
     */
    protected $restApi;

    /**
     * Order constructor.
     *
     * @param string $baseUri
     * @param array $credentials
     */
    public function __construct(
        string $baseUri,
        array $credentials
    ) {
        $this->restApi = new RestApi($baseUri, $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrdersByIntegrationId(string $integrationId, string $searchCriteria = '')
    {
        $endPoint = "rest/V1/integration/{$integrationId}/orders";
        return $this->restApi->get($endPoint . $searchCriteria);
    }

    /**
     * {@inheritdoc}
     */
    public function syncOrders(string $integrationId, string $orderId)
    {
        $endPoint = "rest/V1/integration/{$integrationId}/orders/{$orderId}/history";
        $data = [
            "status" => "synchronized",
            "message" => "The Order has been synchronized"
        ];

        return $this->restApi->post($endPoint, $data);
    }
}
