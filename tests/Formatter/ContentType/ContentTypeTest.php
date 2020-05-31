<?php

declare(strict_types=1);

namespace Test\Formatter\ContentType;

use Betsys\Formatter\ContentType\ContentType;
use Betsys\Formatter\ContentType\InvalidContentTypeException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ContentTypeTest extends TestCase
{

	/**
	 * @dataProvider validArgumentProvider
	 */
	public function testConstructorValid(string $format): void
	{
		$stub = $this->createStub(ContentType::class);
		$reflectedClass = new ReflectionClass(ContentType::class);

		$constructor = $reflectedClass->getConstructor();
		$null = $constructor->invoke($stub, $format);
		// TODO: i'm not sure what to assert here, I only care that no exception is thrown
		$this->assertNull($null);
	}

	/**
	 * @dataProvider invalidArgumentProvider
	 */
	public function testConstructorInValid(string $format): void
	{
		$stub = $this->createStub(ContentType::class);
		$reflectedClass = new ReflectionClass(ContentType::class);

		$constructor = $reflectedClass->getConstructor();

		$this->expectException(InvalidContentTypeException::class);
		$constructor->invoke($stub, $format);
	}

	public function validArgumentProvider(): array
	{
		$reflectedClass = new ReflectionClass(ContentType::class);
		$allowedFormats = $reflectedClass->getConstant('ALLOWED_FORMATS');

		// returns in the correct array[string] format
		return array_map(static fn($f) => [$f], $allowedFormats);
	}

	public function invalidArgumentProvider(): array
	{
		$invalidFormats = ['xls', 'zip', 'png', '', 'x-html', 'json'];
		$reflectedClass = new ReflectionClass(ContentType::class);
		$allowedFormats = $reflectedClass->getConstant('ALLOWED_FORMATS');

		// gets rid of actually valid formats in case they are added in the future
		$invalidFormats = array_diff($invalidFormats, $allowedFormats);

		// returns in the correct array[string] format
		return array_map(static fn($f) => [$f], $invalidFormats);
	}

}
