<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Task;

final class Mapped implements Collection {

	private $collection;
	private $task;

	public function __construct(Collection $collection, Task\Task $task) {
		$this->collection = $collection;
		$this->task = $task;
	}

	public function product(): array {
		return array_map(
			$this->map($this->task),
			$this->collection->product()
		);
	}

	private function map(Task\Task $task): callable {
		return function($value) use ($task) {
			return $task->result($value);
		};
	}
}