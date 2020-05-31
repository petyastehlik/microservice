<?php

declare(strict_types=1);

namespace Test\API;

use Betsys\API\Client;
use Betsys\API\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tracy\ILogger;

final class ClientTest extends TestCase
{

	private Client $client;

	protected function setUp(): void
	{
		$mock = new MockHandler([
			new Response(200, [], 'body'),
			new Response(404),
			new Response(500),
		]);

		$handlerStack = HandlerStack::create($mock);

		$this->client = new Client(['base_uri' => '', 'timeout' => 3.0, 'handler' => $handlerStack], $this->createStub(ILogger::class));
	}

	public function testGetDetail(): void
	{
		$response = $this->client->getDetail('users', 1);
		$this->assertIsString($response);

		$this->expectException(ClientException::class);
		$this->client->getDetail('users', 1);

		$this->expectException(ClientException::class);
		$this->client->getDetail('users', 1);
	}

	public function testGetList(): void
	{
		$response = $this->client->getList('users', 1, 'comments');
		$this->assertIsString($response);

		$this->expectException(ClientException::class);
		$this->client->getList('users', 1, 'comments');

		$this->expectException(ClientException::class);
		$this->client->getList('users', 1, 'comments');
	}

}
