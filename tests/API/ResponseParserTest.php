<?php

declare(strict_types=1);

namespace Test\API;

use Betsys\API\ParsingException;
use Betsys\API\ResponseParser;
use PHPUnit\Framework\TestCase;

final class ResponseParserTest extends TestCase
{

	public function testParseValid(): void
	{
		$jsonFile = __DIR__ . '/data/example.json';

		$parser = new ResponseParser();
		$output = $parser->parse(file_get_contents($jsonFile));

		$this->assertJsonStringEqualsJsonFile($jsonFile, json_encode($output));
	}

	public function testParseInvalid(): void
	{
		$this->expectException(ParsingException::class);
		$parser = new ResponseParser();
		$parser->parse('not a json');
	}

}
