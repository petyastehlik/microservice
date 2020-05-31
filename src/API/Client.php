<?php

declare(strict_types=1);

namespace Betsys\API;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Tracy\ILogger;

final class Client
{

	private \GuzzleHttp\Client $client;

	private ILogger $logger;

	public function __construct(array $config, ILogger $logger)
	{
		$this->client = new \GuzzleHttp\Client($config);
		$this->logger = $logger;
	}

	public function getDetail(string $entity, int $id): string
	{
		$endpoint = "$entity/$id";

		return $this->callEndpoint($endpoint);
	}

	public function getList(string $entity, int $id, string $relation): string
	{
		$endpoint = "$entity/$id/$relation";

		return $this->callEndpoint($endpoint);
	}

	private function callEndpoint(string $endpoint, string $method = 'GET'): string
	{
		$baseUri = $this->client->getConfig('base_uri');
		$request = new Request($method, $baseUri . $endpoint);

		try {
			$response = $this->client->send($request);
			return $response->getBody()->getContents();
		} catch (GuzzleException $e) {
			$this->logger->log(sprintf('HTTP %s: %s', $e->getCode(), $e->getMessage()));
			throw new ClientException($e->getMessage(), $e->getCode(), $e);
		}
	}

}
