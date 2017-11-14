<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Modification;

final class Combined implements Modifier {

	private $modifiers;

	public function __construct(Modifier ...$modifiers) {
		$this->modifiers = $modifiers;
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
		$modifiers = $this->modifiers;
		$modifier = array_shift($modifiers)->result(...$input);
		return array_reduce(
			$modifiers,
			function($return, Modifier $task) {
				return $task->result($return);
			},
			$modifier
		);
	}
}