<?php

declare(strict_types=1);

namespace Betsys\Formatter\ContentType;

use Countable;
use Iterator;

// TODO: implement rest of the collection methods
class ContentTypeCollection implements Iterator, Countable
{

	private int $index = 0;

	private array $items = [];

	public function add(ContentType $contentType): void
	{
		array_push($this->items, $contentType);
	}

	public function count(): int
	{
		return count($this->items);
	}

	public function current(): ContentType
	{
		return $this->items[$this->index];
	}

	public function next(): void
	{
		$this->index++;
	}

	public function key(): int
	{
		return $this->index;
	}

	public function valid(): bool
	{
		return isset($this->items[$this->key()]);
	}

	public function rewind(): void
	{
		$this->index = 0;
	}

}
