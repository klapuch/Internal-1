<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Modification;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Combined extends \Tester\TestCase {

	public function testReturningResultWithOneSingleArgumentTask() {
		Assert::same(
			'2',
			(new Modification\Combined(
				new Modification\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithTwoSingleArgumentTasks() {
		Assert::same(
			'4',
			(new Modification\Combined(
				new Modification\Callback(
					function($value) {
						return $value * 2;
					}
				),
				new Modification\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithManySingleArgumentTasks() {
		Assert::same(
			'16',
			(new Modification\Combined(
				new Modification\Callback(
					function($value) {
						return $value * 2;
					}
				),
				new Modification\Callback(
					function($value) {
						return $value * 4;
					}
				),
				new Modification\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithManyMultiArgumentTasks() {
		Assert::same(
			['1', '2', '3', '4', '5'],
			(new Modification\Combined(
				new Modification\Callback('range'),
				new Modification\Callback(
					function($range) {
						return array_map('strval', $range);
					}
				)
			))->result(1, 5)
		);
	}
}

(new Combined())->run();