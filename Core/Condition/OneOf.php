<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class OneOf implements Condition {

	private $callbacks;

	public function __construct(Condition ...$callbacks) {
		$this->callbacks = $callbacks;
	}

	public function statement(...$input): bool {
		return (new Combined(false, ...$this->callbacks))
			->statement(...$input);
	}
}