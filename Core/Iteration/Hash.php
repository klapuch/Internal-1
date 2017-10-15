<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

final class Hash implements Collection {

	private $elements;

	public function __construct(array $elements) {
		$this->elements = $elements;
	}

	public function elements(): array {
		return $this->elements;
	}
}