<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Reduction\Reduction;

final class Reduced {

	private $collection;
	private $callback;
	private $initial;

	public function __construct(
		Collection $collection,
		Reduction $callback,
		$initial = null
	) {
		$this->collection = $collection;
		$this->callback = $callback;
		$this->initial = $initial;
	}

	/**
	 * @return mixed
	 */
	public function product() {
		return array_reduce(
			$this->collection->product(),
			$this->callback,
			$this->initial
		);
	}
}