<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Integration;

use Dasuos\Internal\Iteration;
use Dasuos\Internal\Modification;
use Dasuos\Internal\Reduction;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Reduced extends \Tester\TestCase {

	public function testReducingHashByTwoCallbacks() {
		Assert::same(
			20,
			(new Iteration\Reduced(
				new Iteration\Hash([1, 2, 3, 4, 5]),
				new Reduction\Combined(
					new Reduction\Callback(
						function($carry, $item) {
							$carry += $item;
							return $carry;
						}
					),
					new Modification\Callback(
						function($item) {
							return ++$item;
						}
					)
				)
			))->product()
		);
	}

	public function testReducingHashByMultipleCallbacks() {
		Assert::same(
			20.0,
			(new Iteration\Reduced(
				new Iteration\Hash([1, 2, 3, 4, 5]),
				new Reduction\Combined(
					new Reduction\Callback(
						function($carry, $item) {
							$carry += $item;
							return $carry;
						}
					),
					new Modification\Callback(
						function($item) {
							return ++$item;
						}
					),
					new Modification\Callback(
						function($item) {
							return floor($item);
						}
					)
				)
			))->product()
		);
	}
}

(new Reduced())->run();