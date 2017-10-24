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

final class All extends \Tester\TestCase {

	public function testReturningTrueStatementWithTwoValidConditions() {
		Assert::same(
			true,
			(new Condition\All(
				new Condition\Callback('is_numeric'),
				new Condition\Callback(
					function($value): bool {
						return $value > 10;
					}
				)
			))->statement('12')
		);
	}

	public function testReturningFalseStatementWithValidAndInvalidCondition() {
		Assert::same(
			false,
			(new Condition\All(
				new Condition\Callback('is_numeric'),
				new Condition\Callback(
					function($value): bool {
						return $value > 10;
					}
				)
			))->statement('10')
		);
	}

	public function testReturningFalseStatementWithTwoInvalidConditions() {
		Assert::same(
			false,
			(new Condition\All(
				new Condition\Callback('is_int'),
				new Condition\Callback(
					function($value): bool {
						return $value === 'bar';
					}
				)
			))->statement('foo')
		);
	}

	public function testReturningTrueStatementWithValidSingleCondition() {
		Assert::same(
			true,
			(new Condition\All(new Condition\Callback('is_int')))
				->statement(10)
		);
	}

	public function testReturningFalseStatementWithInvalidSingleCondition() {
		Assert::same(
			false,
			(new Condition\All(new Condition\Callback('is_int')))
				->statement('foo')
		);
	}

	public function testReturningTrueStatementWithManyValidConditions() {
		Assert::same(
			true,
			(new Condition\All(
				new Condition\Callback(
					function($value): bool {
						return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
					}
				),
				new Condition\Callback(
					function($value): bool {
						return (bool) preg_match('~^.+@bar\.cz$~', $value);
					}
				),
				new Condition\Callback(
					function($value): bool {
						return strlen($value) < 50;
					}
				)
			))->statement('foo@bar.cz')
		);
	}

	public function testReturningTrueStatementWithConditionsWithoutBooleanReturn() {
		Assert::same(
			true,
			(new Condition\All(
				new Condition\Callback(
					function($value) {
						return filter_var($value, FILTER_VALIDATE_EMAIL);
					}
				),
				new Condition\Callback(
					function($value) {
						return preg_match('~^.+@bar\.cz$~', $value);
					}
				)
			))->statement('foo@bar.cz')
		);
	}
}

(new All())->run();
