<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Condition;

final class Filtered implements Iteration {

	private $hash;
	private $conditions;

	public function __construct(
		Collection $hash,
		Condition\Condition ...$conditions
	) {
		$this->hash = $hash;
		$this->conditions = $conditions;
	}

	public function product(): Collection {
		return array_reduce(
			$this->conditions,
			function(Collection $hash, Condition\Condition $condition) {
				return new Hash(
					array_values(
						array_filter(
							$hash->elements(),
							function($value) use ($condition) {
								return $condition->statement($value);
							}
						)
					)
				);
			},
			$this->hash
		);
	}
}