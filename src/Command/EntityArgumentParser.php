<?php

declare(strict_types=1);

namespace Betsys\Command;

use Betsys\Request\EntityWithRelationRequest;
use Symfony\Component\Console\Input\InputInterface;

class EntityArgumentParser
{

	public function parseToRequest(InputInterface $input): EntityWithRelationRequest
	{
		$entity = $input->getArgument('entity');
		$id = (int) $input->getArgument('id');
		$relation = $input->getArgument('relation');

		// TODO: for the other parser I catch another exception and rethrow InvalidArgumentException,
		// maybe I should rethrow here as well, that will allow me to add new exception throws to EntityWithRelationRequest
		// without having to change what is catch-ed in StoreCommand
		return new EntityWithRelationRequest($entity, $id, $relation);
	}

}
