<?php

declare(strict_types=1);

namespace Test\Formatter\ContentType;

use Betsys\Formatter\ContentType\ContentType;
use Betsys\Formatter\ContentType\ContentTypeCollection;
use PHPUnit\Framework\TestCase;

class ContentTypeCollectionTest extends TestCase
{

	/**
	 * @testWith [0]
	 *           [1]
	 *           [123]
	 *           [999]
	 */
	public function testAdd(int $limit): void
	{
		$stub = $this->createStub(ContentType::class);

		$collection = new ContentTypeCollection();
		$this->assertEmpty($collection);

		for ($i = 0; $i < $limit; $i++) {
			$collection->add($stub);
		}

		$this->assertCount($limit, $collection);
	}

}
