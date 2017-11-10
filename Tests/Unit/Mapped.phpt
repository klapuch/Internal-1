<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Iteration;
use Dasuos\Internal\Modification;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Mapped extends \Tester\TestCase {

	public function testMappingSingleHashByAnonymousFunction() {
		Assert::same(
			[2, 4, 6],
			(new Iteration\Mapped(
				new Modification\Callback(
					function($value) {
						return $value * 2;
					}
				),
				new Iteration\Hash([1, 2, 3])
			))->product()
		);
	}

	public function testMappingTwoHashesByAnonymousFunction() {
		Assert::same(
			[1, 4, 9],
			(new Iteration\Mapped(
				new Modification\Callback(
					function($first, $second) {
						return $first * $second;
					}
				),
				new Iteration\Hash([1, 2, 3]),
				new Iteration\Hash([1, 2, 3])
			))->product()
		);
	}

	public function testMappingTwoHashesByNamedFunction() {
		Assert::same(
			[[1,2], [2,3], [3,4,5]],
			(new Iteration\Mapped(
				new Modification\Callback('range'),
				new Iteration\Hash([1, 2, 3]),
				new Iteration\Hash([2, 3, 5])
			))->product()
		);
	}

	public function testMappingManyHashesByAnonymousFunction() {
		Assert::same(
			[1, 8, 27],
			(new Iteration\Mapped(
				new Modification\Callback(
					function($first, $second, $third) {
						return $first * $second * $third;
					}
				),
				new Iteration\Hash([1, 2, 3]),
				new Iteration\Hash([1, 2, 3]),
				new Iteration\Hash([1, 2, 3])
			))->product()
		);
	}

	public function testMappingManyHashesByNamedFunction() {
		Assert::same(
			[[0, 2, 4, 6, 8, 10], [0, 1, 2, 3], [5]],
			(new Iteration\Mapped(
				new Modification\Callback('range'),
				new Iteration\Hash([0, 0, 5]),
				new Iteration\Hash([10, 3, 5]),
				new Iteration\Hash([2, 1, 5])
			))->product()
		);
	}
}

(new Mapped())->run();