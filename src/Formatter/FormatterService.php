<?php

declare(strict_types=1);

namespace Betsys\Formatter;

use Betsys\Formatter\ContentType\ContentType;

class FormatterService
{

	private TemplateBasedFormatterFactory $formatterFactory;

	public function __construct(TemplateBasedFormatterFactory $formatterFactory)
	{
		$this->formatterFactory = $formatterFactory;
	}

	public function formatTo(array $content, ContentType $contentType): string
	{
		$formatter = $this->formatterFactory->createFor($contentType);

		return $formatter->format($content);
	}

}
