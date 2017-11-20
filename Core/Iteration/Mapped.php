<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

use Dasuos\Internal\Modification\Modifier;

final class Mapped implements Collection {

	private $modifier;
	private $collections;

	public function __construct(
		Modifier $modifier,
		Collection ...$collections
	) {
		$this->modifier = $modifier;
		$this->collections = $collections;
	}

	public function product(): array {
		return array_map(
			$this->modifier,
			...(new Hashes(...$this->collections))->product()
		);
	}
}