<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Task;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Combined extends \Tester\TestCase {

	public function testReturningResultWithOneSingleArgumentTask() {
		Assert::same(
			'2',
			(new Task\Combined(
				new Task\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithTwoSingleArgumentTasks() {
		Assert::same(
			'4',
			(new Task\Combined(
				new Task\Callback(
					function($value) {
						return $value * 2;
					}
				),
				new Task\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithManySingleArgumentTasks() {
		Assert::same(
			'16',
			(new Task\Combined(
				new Task\Callback(
					function($value) {
						return $value * 2;
					}
				),
				new Task\Callback(
					function($value) {
						return $value * 4;
					}
				),
				new Task\Callback('strval')
			))->result(2)
		);
	}

	public function testReturningResultWithManyMultiArgumentTasks() {
		Assert::same(
			['1', '2', '3', '4', '5'],
			(new Task\Combined(
				new Task\Callback('range'),
				new Task\Callback(
					function($range) {
						return array_map('strval', $range);
					}
				)
			))->result(1, 5)
		);
	}
}

(new Combined())->run();