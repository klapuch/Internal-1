<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Iteration;
use Dasuos\Internal\Reduction;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Reduced extends \Tester\TestCase {

	public function testReducingHashBySingleCallback() {
		Assert::same(
			15,
			(new Iteration\Reduced(
				new Iteration\Hash([1, 2, 3, 4, 5]),
				new Reduction\Callback(
					function($carry, $item) {
						$carry += $item;
						return $carry;
					}
				)
			))->product()
		);
	}

	public function testReducingHashBySingleCallbackWithInitial() {
		Assert::same(
			25,
			(new Iteration\Reduced(
				new Iteration\Hash([1, 2, 3, 4, 5]),
				new Reduction\Callback(
					function($carry, $item) {
						$carry += $item;
						return $carry;
					}
				),
				10
			))->product()
		);
	}
}

(new Reduced())->run();