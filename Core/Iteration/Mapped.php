<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

final class Mapped implements Collection {

	private $task;
	private $collections;

	public function __construct(callable $task, Collection ...$collections) {
		$this->task = $task;
		$this->collections = $collections;
	}

	public function product(): array {
		return array_map(
			$this->task,
			...$this->products($this->collections)
		);
	}

	private function products(array $collections): array {
		return array_map(
			function(Collection $collection): array {
				return $collection->product();
			},
			$collections
		);
	}
}