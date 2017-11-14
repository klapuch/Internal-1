<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Reduction;

interface Reduction {
	/**
	 * @return mixed
	 */
	public function __invoke($carry, $item);
	/**
	 * @return mixed
	 */
	public function result($carry, $item);
}