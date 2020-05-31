<?php

declare(strict_types=1);

namespace Test\Storage;

use Betsys\Storage\FileSystemStorage;
use PHPUnit\Framework\TestCase;

// TODO: check out and maybe use https://github.com/bovigo/vfsStream/wiki
class FileSystemStorageTest extends TestCase
{

	private string $tempDirectory = __DIR__ . '/../../temp/tests/';

	public function setUp(): void
	{
		if (!is_dir($this->tempDirectory)) {
			mkdir($this->tempDirectory, 0777, true);
		}
	}

	public function tearDown(): void
	{
		// TODO: recursively
		// rmdir($this->tempDirectory);
	}

	public function testStore(): void
	{
		$storage = new FileSystemStorage();
		$storage->store($this->tempDirectory . 'file', 'content');
		$this->assertFileExists($this->tempDirectory . 'file');
	}

	/**
	 * @depends testStore
	 */
	public function testHas(): void
	{
		$storage = new FileSystemStorage();
		$result = $storage->has($this->tempDirectory . 'file');
		$this->assertTrue($result);

		$result = $storage->has($this->tempDirectory . 'nonexistant');
		$this->assertFalse($result);
	}

	/**
	 * @depends testStore
	 */
	public function testDelete(): void
	{
		$storage = new FileSystemStorage();
		$result = $storage->delete($this->tempDirectory . 'file');
		$this->assertFileDoesNotExist($this->tempDirectory . 'file');
		$this->assertTrue($result);

		$result = $storage->delete($this->tempDirectory . 'nonexistant');
		$this->assertFalse($result);
	}

}
