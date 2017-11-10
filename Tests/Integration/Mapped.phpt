<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Integration;

use Dasuos\Internal\Iteration;
use Dasuos\Internal\Modification;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Mapped extends \Tester\TestCase {

	public function testMappingValuesByTwoCombinedTasks() {
		Assert::same(
			['2', '4', '6'],
			(new Iteration\Mapped(
				new Modification\Combined(
					new Modification\Callback(
						function(int $value): int {
							return $value * 2;
						}
					),
					new Modification\Callback('strval')
				),
				new Iteration\Hash([1, 2, 3])
			))->product()
		);
	}

	public function testMappingValuesByManyCombinedTasks() {
		Assert::same(
			['4', '8', '12'],
			(new Iteration\Mapped(
				new Modification\Combined(
					new Modification\Callback(
						function($value): int {
							return $value * 2;
						}
					),
					new Modification\Callback(
						function(int $value): int {
							return $value * 2;
						}
					),
					new Modification\Callback('strval')
				),
				new Iteration\Hash([1, 2, 3])
			))->product()
		);
	}

	public function testMappingValuesByMultiArgumentCombinedTask() {
		Assert::same(
			[[1, 2], [2, 3], [3, 4, 5]],
			(new Iteration\Mapped(
				new Modification\Combined(
					new Modification\Callback('range')
				),
				new Iteration\Hash([1, 2, 3]),
				new Iteration\Hash([2, 3, 5])
			))->product()
		);
	}

}

(new Mapped())->run();