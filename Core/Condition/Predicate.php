<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

interface Predicate {
	public function __invoke(...$input): bool;
	public function statement(...$input): bool;
}