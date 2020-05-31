<?php

declare(strict_types=1);

namespace Test\Command;

use Betsys\Command\FormatArgumentParser;
use Betsys\Command\InvalidArgumentException;
use Betsys\Formatter\ContentType\ContentTypeCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class FormatArgumentParserTest extends TestCase
{

	/**
	 * @dataProvider validArgumentsProvider
	 */
	public function testParseToCollection(InputInterface $input): void
	{
		$parser = new FormatArgumentParser();
		$collection = $parser->parseToCollection($input);

		$this->assertInstanceOf(ContentTypeCollection::class, $collection);
		$this->assertCount(3, $collection);
	}

	/**
	 * @dataProvider validArgumentsPartialProvider
	 */
	public function testParseToCollectionOnlySomeFormats(InputInterface $input): void
	{
		$parser = new FormatArgumentParser();
		$collection = $parser->parseToCollection($input);

		$this->assertInstanceOf(ContentTypeCollection::class, $collection);
		$this->assertCount(2, $collection);
	}

	/**
	 * @dataProvider emptyArgumentsProvider
	 */
	public function testParseToCollectionEmpty(InputInterface $input): void
	{
		$parser = new FormatArgumentParser();
		$collection = $parser->parseToCollection($input);

		$this->assertInstanceOf(ContentTypeCollection::class, $collection);
		$this->assertCount(0, $collection);
	}

	/**
	 * @dataProvider invalidArgumentsProvider
	 */
	public function testParseToCollectionInvalid(InputInterface $input): void
	{
		$this->expectException(InvalidArgumentException::class);
		$parser = new FormatArgumentParser();
		$parser->parseToCollection($input);
	}

	// TODO: refactor data providers
	public function validArgumentsProvider(): array
	{
		return [
			'comma-delimited multiple' => [$this->createStubInput(['json,xml,html'])],
			'comma-delimited repeating' => [$this->createStubInput(['json,xml,html,html,xml,json'])],
			'array as intended' => [$this->createStubInput(['json', 'xml', 'html'])],
			'combined' => [$this->createStubInput(['json,xml,html', 'json', 'xml', 'html'])],
		];
	}

	public function validArgumentsPartialProvider(): array
	{
		return [
			'comma-delimited multiple' => [$this->createStubInput(['json,xml'])],
			'comma-delimited repeating' => [$this->createStubInput(['json,xml,xml,json'])],
			'array as intended' => [$this->createStubInput(['json', 'xml'])],
			'combined' => [$this->createStubInput(['json,xml', 'xml',])],
		];
	}

	public function emptyArgumentsProvider(): array
	{
		return ['empty set' => [$this->createStubInput([])]];
	}

	public function invalidArgumentsProvider(): array
	{
		return [
			'invalid format' => [$this->createStubInput(['pdf'])],
			'weird delimiter' => [$this->createStubInput(['xml-json-html'])],
		];
	}

	private function createStubInput(array $return): InputInterface
	{
		$stub = $this->createStub(InputInterface::class);
		$stub->method('getOption')->willReturn($return);

		return $stub;
	}

}
