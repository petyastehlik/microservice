<?php

declare(strict_types=1);

namespace Betsys\Command;

use Betsys\API\ClientException;
use Betsys\API\ParsingException;
use Betsys\Blog\BlogFacade;
use Betsys\Storage\FileManager;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\ILogger;

final class StoreCommand extends Command
{

	private string $commandName = 'store';

	private BlogFacade $blogFacade;

	private FormatArgumentParser $formatArgumentParser;

	private EntityArgumentParser $entityArgumentParser;

	private FileManager $fileManager;

	private ILogger $logger;

	public function __construct(
		BlogFacade $blogFacade,
		FormatArgumentParser $formatArgumentParser,
		EntityArgumentParser $entityArgumentParser,
		FileManager $fileManager,
		ILogger $logger
	) {
		parent::__construct($this->commandName);
		$this->blogFacade = $blogFacade;
		$this->formatArgumentParser = $formatArgumentParser;
		$this->entityArgumentParser = $entityArgumentParser;
		$this->fileManager = $fileManager;
		$this->logger = $logger;
	}

	protected function configure(): void
	{
		$description = 'Reads a list of posts, comments and users from remote API (https://jsonplaceholder.typicode.com/) and stores count of relations and „entity“ informations';

		$this->setDescription($description)
			->addArgument('entity', InputArgument::REQUIRED, 'Type of entity')
			->addArgument('id', InputArgument::REQUIRED, 'Id of entity')
			->addArgument('relation', InputArgument::REQUIRED, 'Relation to entity')
			->addOption('format', 'f', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'File formats in which to store result data');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		try {
			$entityWithRelationRequest = $this->entityArgumentParser->parseToRequest($input);
			$contentTypeCollection = $this->formatArgumentParser->parseToCollection($input);
			$entityWithCount = $this->blogFacade->getDetailWithCountFor($entityWithRelationRequest);

			$entityIdentifier = $entityWithRelationRequest->getType() . '-' . $entityWithRelationRequest->getId();
			$this->fileManager->saveDataAsFileTypes($entityIdentifier, $entityWithCount, $contentTypeCollection);
		} catch (InvalidArgumentException | ParsingException $e) {
			$this->logger->log($e, ILogger::INFO);
			$output->writeln('<error>Error: ' . $e->getMessage() . '</error>');

			return 1;
		} catch (ClientException $e) {
			$this->logger->log($e, ILogger::WARNING);
			$output->writeln('<comment>Warning: API error occured: ' . $e->getCode() . '</comment>');
			$output->writeln('<error>Error: ' . $e->getMessage() . '</error>');

			return 1;
		} catch (Exception $e) {
			$this->logger->log($e, ILogger::ERROR);
			$output->writeln('<error>Error: Unexpected error ocurred:</error>');
			$output->writeln('<error>' . $e->getMessage() . '</error>');

			return 1;
		}

		return 0;
	}

}
