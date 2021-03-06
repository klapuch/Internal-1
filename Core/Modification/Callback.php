<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Modification;

final class Callback implements Modifier {

	private $callback;

	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	/**
	 * @return mixed
	 */
	public function __invoke(...$input) {
		return $this->result(...$input);
	}

	/**
	 * @return mixed
	 */
	public function result(...$input) {
		return call_user_func_array($this->callback, $input);
	}
}