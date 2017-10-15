<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

final class Callback implements Condition {

	private $callback;

	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	public function statement($input): bool {
		try {
			return call_user_func($this->callback, $input);
		} catch (\Throwable $exception) {
			throw new \UnexpectedValueException(
				'Callback does not satisfy functionality requirements',
				0,
				$exception->getPrevious()
			);
		}
	}
}