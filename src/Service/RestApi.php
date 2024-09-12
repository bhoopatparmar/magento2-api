<?php
declare(strict_types=1);

namespace Salecto\Magento2Api\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

/**
 * Class RestApi
 *
 * Handles API requests using GuzzleHttp with support for Bearer and OAuth 1.0 authentication.
 */
class RestApi implements RestApiInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Base URI for the Magento 2 API.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Authentication type (Bearer or OAuth 1.0).
     *
     * @var string
     */
    protected $authType;

    /**
     * Authentication credentials (Bearer token or OAuth credentials).
     *
     * @var array|string
     */
    protected $credentials;

    /**
     * RestApi constructor.
     *
     * @param string $baseUri
     * @param array $credentials
     */
    public function __construct(
        string $baseUri,
        array $credentials
    ) {
        $this->baseUri = rtrim($baseUri, '/') . '/';
        $this->authType = $credentials['auth_type'];
        $this->credentials = $credentials['auth_key'];
        $this->client = $this->initializeClient();
    }

    /**
     * Initialize the Guzzle client.
     *
     * @return Client
     */
    protected function initializeClient(): Client
    {
        $clientOptions['base_uri'] = $this->baseUri;

        if ($this->authType === self::AUTH_OAUTH1 && is_array($this->credentials)) {
            $stack = HandlerStack::create();
            $middleware = new Oauth1([
                'consumer_key'      => $this->credentials['consumer_key'] ?? '',
                'consumer_secret'   => $this->credentials['consumer_secret'] ?? '',
                'token'             => $this->credentials['token'] ?? '',
                'token_secret'      => $this->credentials['token_secret'] ?? '',
                'signature_method'  => Oauth1::SIGNATURE_METHOD_HMACSHA256,
            ]);

            $stack->push($middleware);
            $clientOptions['handler'] = $stack;
            $clientOptions['auth'] = 'oauth';
        }
        return new Client($clientOptions);
    }

    /**
     * Get authentication options based on the auth type.
     *
     * @return array
     * @throws Exception
     */
    protected function getAuthOptions(): array
    {
        switch ($this->authType) {
            case self::AUTH_BEARER:
                return [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->credentials,
                        'Content-Type'  => 'application/json'
                    ]
                ];

            case self::AUTH_OAUTH1:
                return []; // OAuth 1.0 is handled during client initialization
            default:
                throw new Exception('Unsupported authentication type');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, string $uri, array $data = null)
    {
        try {
            $options = $this->getAuthOptions();

            if ($data !== null && in_array($method, [self::POST_REQUEST, self::PUT_REQUEST]) ) {
                $options['body'] = json_encode($data);
            }

            $response = $this->client->request($method, $uri, $options);

            return $response->getStatusCode() === 200
                ? json_decode($response->getBody()->getContents(), true)
                : $response['message'] ?? '';
        } catch (RequestException $e) {
            throw new Exception('HTTP request failed: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Error occurred during the API call: ' . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $uri, array $data)
    {
        return $this->request(self::POST_REQUEST, $uri, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $uri, array $data)
    {
        return $this->request(self::PUT_REQUEST, $uri, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $uri)
    {
        return $this->request(self::DELETE_REQUEST, $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $uri)
    {
        return $this->request(self::GET_REQUEST, $uri);
    }
}
