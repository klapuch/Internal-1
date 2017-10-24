<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Condition;

final class Filtered implements Collection {

	public const VALUES = 0, BOTH = 1, KEYS = 2;
	private const SELECTIONS = [self::VALUES, self::BOTH, self::KEYS];

	private $collection;
	private $condition;
	private $flag;

	public function __construct(
		Collection $collection,
		Condition\Condition $condition,
		int $flag = self::VALUES
	) {
		$this->collection = $collection;
		$this->condition = $condition;
		$this->flag = $flag;
	}

	public function product(): array {
		$selection = $this->selection($this->flag);
		return array_filter(
			$this->collection->product(),
			$this->filter($this->condition, $selection),
			$selection
		);
	}

	private function selection(int $flag): int {
		if (!in_array($flag, self::SELECTIONS, true))
			throw new \UnexpectedValueException(
				'Filter selection flag is not valid'
			);
		return $flag;
	}

	private function filter(
		Condition\Condition $condition,
		int $selection
	): callable {
		return $selection === self::BOTH
			? $this->both($condition)
			: $this->part($condition);
	}

	private function both(Condition\Condition $condition): callable {
		return function($value, $key) use ($condition): bool {
			return $condition->statement($value, $key);
		};
	}

	private function part(Condition\Condition $condition): callable {
		return function($value) use ($condition): bool {
			return $condition->statement($value);
		};
	}
}