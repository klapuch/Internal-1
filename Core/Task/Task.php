<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Task;

interface Task {
	/**
	 * @return mixed
	 */
	public function __invoke(...$input);
	/**
	 * @return mixed
	 */
	public function result(...$input);
}