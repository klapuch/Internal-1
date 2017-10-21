<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class Callback implements Condition {

	private $callback;

	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	public function statement(...$input): bool {
		return call_user_func_array($this->callback, $input);
	}
}