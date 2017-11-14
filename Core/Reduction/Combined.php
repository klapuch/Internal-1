<?php
declare(strict_types = 1);
namespace Dasuos\Internal\Reduction;

use Dasuos\Internal\Modification\Modifier;

final class Combined implements Reduction {

	private $reduction;
	private $modifiers;

	public function __construct(Reduction $reduction, Modifier ...$modifiers) {
		$this->reduction = $reduction;
		$this->modifiers = $modifiers;
	}

	/**
	 * @return mixed
	 */
	public function __invoke($carry, $item) {
		return $this->result($carry, $item);
	}

	/**
	 * @return mixed
	 */
	public function result($carry, $item) {
		return array_reduce(
			$this->modifiers,
			function($return, Modifier $task) {
				return $task->result($return);
			},
			$this->reduction->result($carry, $item)
		);
	}
}