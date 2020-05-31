<?php

declare(strict_types=1);

namespace Betsys\Request;

use Betsys\Command\InvalidArgumentException;

class EntityWithRelationRequest
{

	private const ALLOWED_ENTITY = ['users', 'posts'];

	private const ALLOWED_ENTITY_RELATIONS = ['users' => ['posts', 'comments'], 'posts' => ['comments']];

	private string $entity;

	private int $id;

	private string $relation;

	public function __construct(string $entity, int $id, string $relation)
	{
		if ($id <= 0) {
			throw new InvalidArgumentException(sprintf('Entity ID must be a positive integer, %s provided', $id));
		}

		if (! in_array($entity, self::ALLOWED_ENTITY)) {
			throw new InvalidArgumentException(sprintf('Unknown entity type %s provided, must be one of %s', $entity, implode(', ', self::ALLOWED_ENTITY)));
		}

		if (! in_array($relation, self::ALLOWED_ENTITY_RELATIONS[$entity])) {
			throw new InvalidArgumentException(sprintf('Unsupported entity relation %s for entity %s provided', $relation, $entity));
		}

		$this->entity = $entity;
		$this->id = $id;
		$this->relation = $relation;
	}

	public function getType(): string
	{
		return $this->entity;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getRelation(): string
	{
		return $this->relation;
	}

}
