<?php

declare(strict_types=1);

namespace Betsys\Storage;

interface IStorage
{

	public function store(string $key, string $content): bool;

	public function has(string $key): bool;

	public function delete(string $key): bool;

}
