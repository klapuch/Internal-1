<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class Combined implements Predicate {

	private $initial;
	private $callbacks;

	public function __construct(bool $initial, Predicate ...$callbacks) {
		$this->initial = $initial;
		$this->callbacks = $callbacks;
	}

	public function __invoke(...$input): bool {
		return $this->statement(...$input);
	}

	/**
	 * @internal
	 * @param mixed ...$input
	 * @return bool
	 */
	public function statement(...$input): bool {
		return (bool) array_reduce(
			$this->callbacks,
			$this->initial
				? $this->conjunction($input)
				: $this->disjunction($input),
			$this->initial
		);
	}

	private function conjunction(array $input): callable {
		return function(
			bool $evaluation,
			Predicate $predicate
		) use ($input): bool {
			return $evaluation && $predicate->statement(...$input);
		};
	}

	private function disjunction(array $input): callable {
		return function(
			bool $evaluation,
			Predicate $predicate
		) use ($input): bool {
			return $evaluation || $predicate->statement(...$input);
		};
	}
}