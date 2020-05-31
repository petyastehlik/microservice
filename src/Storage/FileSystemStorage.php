<?php

declare(strict_types=1);

namespace Betsys\Storage;

// TODO: add checks for missing directories, insufficent permissions
// or better yet just make it an adapter class for a well-tested FS library
final class FileSystemStorage implements IStorage
{

	public function store(string $filePath, string $content): bool
	{
		return (bool) file_put_contents($filePath, $content);
	}

	public function has(string $filePath): bool
	{
		return is_file($filePath);
	}

	public function delete(string $filePath): bool
	{
		if ($this->has($filePath)) {
			unlink($filePath);
			return true;
		}

		return false;
	}

}
