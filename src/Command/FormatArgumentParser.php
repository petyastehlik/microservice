<?php

declare(strict_types=1);

namespace Betsys\Command;

use Betsys\Formatter\ContentType\ContentType;
use Betsys\Formatter\ContentType\ContentTypeCollection;
use Betsys\Formatter\ContentType\InvalidContentTypeException;
use Symfony\Component\Console\Input\InputInterface;

class FormatArgumentParser
{

	public function parseToCollection(InputInterface $input): ContentTypeCollection
	{
		$option = $input->getOption('format');
		$formats = $this->normalizeArguments($option);
		$collection = new ContentTypeCollection();

		foreach ($formats as $format) {
			try {
				$contentType = new ContentType($format);
				$collection->add($contentType);
			} catch (InvalidContentTypeException $e) {
				throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
			}
		}

		return $collection;
	}

	/**
	 * The CLI array input option is supposed to be entered as e.g.: --format=xml --format=json
	 * however, I'd expect it to be comma-delimited e.g.: --format=xml,json
	 * - this allows for both cases.
	 *
	 * @param array $args
	 * @return array
	 */
	private function normalizeArguments(array $args): array
	{
		$output = [];
		foreach ($args as $arg) {
			$output = array_merge($output, explode(',', $arg));
		}

		return array_unique($output);
	}

}
