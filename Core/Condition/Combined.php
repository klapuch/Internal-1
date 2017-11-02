<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class Combined implements Condition {

	private $initial;
	private $callbacks;

	public function __construct(bool $initial, Condition ...$callbacks) {
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
			bool $statement,
			Condition $condition
		) use ($input): bool {
			return $statement && $condition->statement(...$input);
		};
	}

	private function disjunction(array $input): callable {
		return function(
			bool $statement,
			Condition $condition
		) use ($input): bool {
			return $statement || $condition->statement(...$input);
		};
	}
}