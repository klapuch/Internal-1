<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Modification;

interface Modifier {
	/**
	 * @return mixed
	 */
	public function __invoke(...$input);
	/**
	 * @return mixed
	 */
	public function result(...$input);
}