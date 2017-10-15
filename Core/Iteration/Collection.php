<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Iteration;

interface Collection {
	public function elements(): array;
}