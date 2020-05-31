<?php

declare(strict_types=1);

namespace Test\API;

use Betsys\Command\StoreCommand;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

final class StoreCommandTest extends TestCase
{

	/**
	 * @dataProvider executeProvider
	 */
	public function testExecute(string $entity, int $id, string $relation, ?array $format): void
	{
		$reflectedClass = new ReflectionClass(StoreCommand::class);
		$constructor = $reflectedClass->getConstructor();
		$parameters = $constructor->getParameters();

		$stubArguments = [];
		foreach ($parameters as $parameter) {
			$className = $parameter->getClass()->getName();
			$stubArguments[] = $this->createStub($className);
		}

		$application = new Application();
		$application->add(new StoreCommand(...$stubArguments));
		$command = $application->find('store');
		$commandTester = new CommandTester($command);

		// build argument list from data provider
		$arguments = [
			'entity' => $entity,
			'id' => $id,
			'relation' => $relation,
		];

		// format argument is optional
		if ($format !== null) {
			$arguments['--format'] = $format;
		}

		$commandTester->execute($arguments);

		$outputCode = $commandTester->getStatusCode();
		$this->assertEquals(0, $outputCode);
	}

	public function executeProvider(): array
	{
		return [
			'minimum arguments' => ['users', 1, 'comments', null],
			'full arguments' => ['users', 1, 'comments', ['xml', 'json', 'html']],
		];
	}

}
