<?php

declare(strict_types=1);

namespace Betsys\API;

final class Enricher
{

	public function enrichWithCount(array $detail, string $relationName, array $list): array
	{
		$detail['relations'][$relationName]['count'] = count($list);

		return $detail;
	}

}
