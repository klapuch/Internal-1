<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Modification;

final class Combined implements Modifier {

	private $tasks;

	public function __construct(Modifier ...$tasks) {
		$this->tasks = $tasks;
	}

	/**
	 * @return mixed
	 */
	public function __invoke(...$input) {
		return $this->result(...$input);
	}

	/**
	 * @return mixed
	 */
	public function result(...$input) {
		$tasks = $this->tasks;
		$task = array_shift($tasks)->result(...$input);
		return array_reduce(
			$tasks,
			function($return, Modifier $task) {
				return $task->result($return);
			},
			$task
		);
	}
}