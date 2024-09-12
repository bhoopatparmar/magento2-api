<?php
declare(strict_types=1);

namespace Salecto\Magento2Api\Service;

/**
 * Interface RestApiInterface
 */
interface RestApiInterface
{
    const GET_REQUEST = 'GET';

    const POST_REQUEST = 'POST';

    const PUT_REQUEST = 'PUT';

    const DELETE_REQUEST = 'DELETE';

    const AUTH_BEARER = 'Bearer';

    const AUTH_OAUTH1 = 'OAuth1';

    /**
     * Make a request to the API.
     *
     * @param string $method
     * @param string $uri
     * @param array|null $data
     * @return array|string
     * @throws \Exception
     */
    public function request(string $method, string $uri, array $data = null);

    /**
     * Make a POST request to the API.
     *
     * @param string $uri
     * @param array $data
     * @return array|string
     * @throws \Exception
     */
    public function post(string $uri, array $data);

    /**
     * Make a PUT request to the API.
     *
     * @param string $uri
     * @return array|string
     * @throws \Exception
     */
    public function put(string $uri, array $data);

    /**
     * Make a DELETE request to the API.
     *
     * @param string $uri
     * @return array|string
     * @throws \Exception
     */
    public function delete(string $uri);

    /**
     * Make a GET request to the API.
     *
     * @param string $uri
     * @return array|string
     * @throws \Exception
     */
    public function get(string $uri);
}
