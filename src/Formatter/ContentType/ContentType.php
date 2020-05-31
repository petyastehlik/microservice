<?php

declare(strict_types=1);

namespace Betsys\Formatter\ContentType;

class ContentType
{

	private string $type;

	private const ALLOWED_FORMATS = ['xml', 'json', 'html'];

	public function __construct(string $format)
	{
		if (!in_array($format, self::ALLOWED_FORMATS)) {
			throw new InvalidContentTypeException(
				sprintf(
					'Invalid format %s provided. Allowed formats are %s',
					$format,
					implode(', ', self::ALLOWED_FORMATS)
				)
			);
		}

		$this->type = $format;
	}

	public function __toString(): string
	{
		return $this->type;
	}

}
