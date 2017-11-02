<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

final class Jagged implements Collection {

	private $collections;

	public function __construct(Collection ...$collections) {
		$this->collections = $collections;
	}

	public function product(): array {
		return array_map(
			null,
			...(new Hashes(...$this->collections))->product()
		);
	}
}