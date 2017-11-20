<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Condition\Predicate;

final class Filtered implements Collection {

	public const VALUES = 0, BOTH = 1, KEYS = 2;

	private $collection;
	private $predicate;
	private $flag;

	public function __construct(
		Collection $collection,
		Predicate $predicate,
		int $flag = self::VALUES
	) {
		$this->collection = $collection;
		$this->predicate = $predicate;
		$this->flag = $flag;
	}

	public function product(): array {
		return array_filter(
			$this->collection->product(),
			$this->predicate,
			$this->flag
		);
	}
}