<?php

declare(strict_types=1);

namespace Betsys\API;

use JsonException;

final class ResponseParser
{

	public function parse(string $jsonString): array
	{
		try {
			return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
		} catch (JsonException $e) {
			throw new ParsingException($e->getMessage(), $e->getCode(), $e);
		}
	}

}
