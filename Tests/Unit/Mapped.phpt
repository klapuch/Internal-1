<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Iteration;
use Dasuos\Internal\Task;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Mapped extends \Tester\TestCase {

	public function testMappingValuesByAnonymousFunction() {
		Assert::same(
			[2, 4, 6],
			(new Iteration\Mapped(
				new Iteration\Hash([1, 2, 3]),
				new Task\Callback(
					function($value) {
						return $value * 2;
					}
				)
			))->product()
		);
	}
}

(new Mapped())->run();