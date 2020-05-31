<?php

declare(strict_types=1);

namespace Betsys\Formatter;

use Betsys\Formatter\ContentType\ContentType;
use Latte\Engine;

final class TemplateBasedFormatterFactory
{

	public function createFor(ContentType $contentType): IContentTypeFormatter
	{
		$engine = new Engine();
		$templatePath = __DIR__ . '/template/' . $contentType . '.latte';

		return new TemplateBasedFormatter($engine, $templatePath);
	}

}
