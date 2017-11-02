<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

final class Hashes implements Collection {

	private $parts;

	public function __construct(Collection ...$parts) {
		$this->parts = $parts;
	}

	public function product(): array {
		return array_map(
			function(Collection $collection): array {
				return $collection->product();
			},
			$this->parts
		);
	}
}