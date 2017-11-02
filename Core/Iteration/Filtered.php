<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Condition;

final class Filtered implements Collection {

	public const VALUES = 0, BOTH = 1, KEYS = 2;

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
		return array_filter(
			$this->collection->product(),
			$this->condition,
			$this->flag
		);
	}
}