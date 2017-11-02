<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Iteration;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Jagged extends \Tester\TestCase {

	public function testJoiningElementsOfManyArrays() {
		Assert::same(
			[
				[1, 'one', 'uno'],
				[2, 'two', 'dos'],
				[3, 'three', 'tres'],
				[4, 'four', 'cuatro'],
				[5, 'five', 'cinco'],
			],
			(new Iteration\Jagged(
				new Iteration\Hash([1, 2, 3, 4, 5]),
				new Iteration\Hash(['one', 'two', 'three', 'four', 'five']),
				new Iteration\Hash(['uno', 'dos', 'tres', 'cuatro', 'cinco'])
			))->product()
		);
	}
}

(new Jagged())->run();