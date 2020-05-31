<?php

declare(strict_types=1);

namespace Betsys\Formatter;

interface IContentTypeFormatter
{

	public function format(array $data): string;

}
