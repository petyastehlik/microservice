<?php

declare(strict_types=1);

namespace Betsys\Formatter;

use Latte\Engine;

final class TemplateBasedFormatter implements IContentTypeFormatter
{

	private string $templatePath;

	private Engine $engine;

	public function __construct(Engine $engine, string $templatePath)
	{
		$this->templatePath = $templatePath;
		$this->engine = $engine;
	}

	public function format(array $content): string
	{
		return $this->engine->renderToString($this->templatePath, ['data' => $content]);
	}

}
