<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Condition\Condition;

final class Filtered implements Collection {

	public const VALUES = 0, BOTH = 1, KEYS = 2;

	private $collection;
	private $condition;
	private $selection;

	public function __construct(
		Collection $collection,
		Condition $condition,
		int $selection = self::VALUES
	) {
		$this->collection = $collection;
		$this->condition = $condition;
		$this->selection = $selection;
	}

	public function product(): array {
		return array_filter(
			$this->collection->product(),
			$this->condition,
			$this->selection
		);
	}
}