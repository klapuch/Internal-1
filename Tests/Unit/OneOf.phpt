<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Unit;

use Dasuos\Internal\Condition;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class OneOf extends \Tester\TestCase {

	public function testReturningTrueStatementWithOneOfValidConditions() {
		Assert::same(
			true,
			(new Condition\OneOf(
				new Condition\Callback('is_int'),
				new Condition\Callback('is_numeric')
			))->statement('12')
		);
	}

	public function testReturningFalseStatementWithNoValidConditions() {
		Assert::same(
			false,
			(new Condition\OneOf(
				new Condition\Callback('is_int'),
				new Condition\Callback('is_int')
			))->statement('12')
		);
	}

	public function testReturningTrueStatementWithSingleValidCondition() {
		Assert::same(
			true,
			(new Condition\OneOf(
				new Condition\Callback('is_int')
			))->statement(12)
		);
	}

	public function testReturningFalseStatementWithSingleInvalidCondition() {
		Assert::same(
			false,
			(new Condition\OneOf(
				new Condition\Callback('is_int')
			))->statement('foo')
		);
	}

	public function testReturningTrueStatementWithBothValidConditions() {
		Assert::same(
			true,
			(new Condition\OneOf(
				new Condition\Callback('is_numeric'),
				new Condition\Callback(
					function($value): bool {
						return $value > 10;
					}
				)
			))->statement(12)
		);
	}

	public function testReturningTrueStatementWithOneOfManyConditions() {
		Assert::same(
			true,
			(new Condition\OneOf(
				new Condition\Callback('is_string'),
				new Condition\Callback(
					function($value): bool {
						return $value > 10;
					}
				),
				new Condition\Callback(
					function($value): bool {
						return $value !== 12;
					}
				)
			))->statement(12)
		);
	}
}

(new OneOf())->run();
