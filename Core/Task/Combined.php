<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Task;

final class Combined implements Task {

	private $tasks;

	public function __construct(Task ...$tasks) {
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
			function($return, Task $task) {
				return $task->result($return);
			},
			$task
		);
	}
}