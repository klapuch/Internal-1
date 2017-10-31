<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Task\Task;

final class Mapped implements Collection {

	private $task;
	private $collections;

	public function __construct(Task $task, Collection ...$collections) {
		$this->task = $task;
		$this->collections = $collections;
	}

	public function product(): array {
		return array_map(
			$this->task,
			...array_map(
				function(Collection $collection): array {
					return $collection->product();
				},
				$this->collections
			)
		);
	}
}