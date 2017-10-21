<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Condition;

interface Condition {
	public function statement(...$input): bool;
}