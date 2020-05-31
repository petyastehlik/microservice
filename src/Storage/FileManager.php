<?php

declare(strict_types=1);

namespace Betsys\Storage;

use Betsys\Formatter\ContentType\ContentTypeCollection;
use Betsys\Formatter\FormatterService;

class FileManager
{

	private string $outputDirectory;

	private FormatterService $formatterService;

	private StorageService $storageService;

	public function __construct(string $outputDirectory, FormatterService $formatterService, StorageService $storageService)
	{
		$this->outputDirectory = $outputDirectory;
		$this->formatterService = $formatterService;
		$this->storageService = $storageService;
	}

	public function saveDataAsFileTypes(string $entityIdentifier, array $entity, ContentTypeCollection $contentTypeCollection): void
	{
		foreach ($contentTypeCollection as $contentType) {
			$filePath = $this->outputDirectory . $entityIdentifier . '.' . $contentType;
			$formattedContent = $this->formatterService->formatTo($entity, $contentType);
			$this->storageService->store($filePath, $formattedContent);
		}
	}

}
