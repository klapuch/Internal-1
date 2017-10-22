<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class All implements Condition {

	private $callbacks;

	public function __construct(Condition ...$callbacks) {
		$this->callbacks = $callbacks;
	}

	public function statement(...$input): bool {
		return array_reduce(
			$this->callbacks,
			function(bool $statement, Condition $condition) use ($input) {
				return $statement && $condition->statement(...$input);
			},
			true
		);
	}
}