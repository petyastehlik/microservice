<?php

declare(strict_types=1);

namespace Betsys\Blog;

use Betsys\API\Client;
use Betsys\API\Enricher;
use Betsys\API\ResponseParser;
use Betsys\Request\EntityWithRelationRequest;
use Psr\SimpleCache\CacheInterface;

class BlogFacade
{

	private Client $client;

	private ResponseParser $parser;

	private Enricher $enricher;

	private CacheInterface $cache;

	public function __construct(CacheInterface $cache, Client $client, ResponseParser $parser, Enricher $enricher)
	{
		$this->client = $client;
		$this->parser = $parser;
		$this->enricher = $enricher;
		$this->cache = $cache;
	}

	// TODO: refactor this to make it more readable
	public function getDetailWithCountFor(EntityWithRelationRequest $request): array
	{
		$entity = $request->getType();
		$id = $request->getId();
		$relation = $request->getRelation();

		$cacheKey = "$entity.$id";
		if ($this->cache->has($cacheKey)) {
			$detailResult = $this->cache->get($cacheKey);
		} else {
			$detailResult = $this->client->getDetail($entity, $id);
			$this->cache->set($cacheKey, $detailResult);
		}

		$cacheKey = "$entity.$id.$relation";
		if ($this->cache->has($cacheKey)) {
			$listResult = $this->cache->get($cacheKey);
		} else {
			$listResult = $this->client->getList($entity, $id, $relation);
			$this->cache->set($cacheKey, $listResult);
		}

		$detail = $this->parser->parse($detailResult);
		$list = $this->parser->parse($listResult);

		return $this->enricher->enrichWithCount($detail, $relation, $list);
	}

}
