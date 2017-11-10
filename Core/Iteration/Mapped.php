<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Modification\Modifier;

final class Mapped implements Collection {

	private $task;
	private $collections;

	public function __construct(Modifier $task, Collection ...$collections) {
		$this->task = $task;
		$this->collections = $collections;
	}

	public function product(): array {
		return array_map(
			$this->task,
			...(new Hashes(...$this->collections))->product()
		);
	}
}