<?php

declare(strict_types=1);

namespace Betsys\Storage;

class StorageService
{

	private IStorage $storage;

	public function __construct(IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function store(string $filePath, string $content): void
	{
		$this->storage->store($filePath, $content);
	}

}
