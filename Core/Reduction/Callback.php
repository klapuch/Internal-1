<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Reduction;

final class Callback implements Reduction {

	private $callback;

	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	/**
	 * @return mixed
	 */
	public function __invoke($carry, $item) {
		return $this->result($carry, $item);
	}

	/**
	 * @return mixed
	 */
	public function result($carry, $item) {
		return call_user_func_array($this->callback, [$carry, $item]);
	}
}