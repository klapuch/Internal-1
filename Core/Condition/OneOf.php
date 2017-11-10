<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class OneOf implements Predicate {

	private $callbacks;

	public function __construct(Predicate ...$callbacks) {
		$this->callbacks = $callbacks;
	}

	public function __invoke(...$input): bool {
		return $this->statement(...$input);
	}

	public function statement(...$input): bool {
		return (new Combined(false, ...$this->callbacks))
			->statement(...$input);
	}
}