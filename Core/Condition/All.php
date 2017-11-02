<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class All implements Condition {

	private $callbacks;

	public function __construct(Condition ...$callbacks) {
		$this->callbacks = $callbacks;
	}

	public function __invoke(...$input): bool {
		return $this->statement(...$input);
	}

	public function statement(...$input): bool {
		return (new Combined(true, ...$this->callbacks))
			->statement(...$input);
	}
}