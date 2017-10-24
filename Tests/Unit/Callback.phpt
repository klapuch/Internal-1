<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Integration;

use Dasuos\Internal\Condition;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Callback extends \Tester\TestCase {

	public function testReturningTrueStatementWithOneArgument() {
		Assert::true(
			(new Condition\Callback('is_int'))->statement(5)
		);
	}

	public function testReturningFalseStatementWithOneArgument() {
		Assert::false(
			(new Condition\Callback('is_int'))->statement('foo')
		);
	}

	public function testReturningStatementWithMoreArguments() {
		Assert::true(
			(new Condition\Callback(
				function($value, $key): bool {
					return is_string($value) && is_int($key);
				}
			))->statement('foo', 0)
		);
	}
}

(new Callback())->run();
