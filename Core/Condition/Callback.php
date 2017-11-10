<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class Callback implements Predicate {

	private $callback;

	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	public function __invoke(...$input): bool {
		return $this->statement(...$input);
	}

	public function statement(...$input): bool {
		return (bool) call_user_func_array($this->callback, $input);
	}
}