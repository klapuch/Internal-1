<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Configuration\Integration;

use Dasuos\Internal\Condition;
use Dasuos\Internal\Iteration;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Filtered extends \Tester\TestCase {

	public function testFilteringHashByNamedFunction() {
		Assert::equal(
			new Iteration\Hash([1, 2, 3]),
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback('is_numeric')
			))->product()
		);
	}

	public function testFilteringHashByAnonymousFunction() {
		Assert::equal(
			new Iteration\Hash(['string']),
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback(
					function($value) {
						return is_string($value);
					}
				)
			))->product()
		);
	}

	public function testFilteringHashByCombinedCallbacks() {
		Assert::equal(
			new Iteration\Hash([]),
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback(
					function($value) {
						return is_string($value);
					}
				),
				new Condition\Callback('is_numeric')
			))->product()
		);
	}

	public function testThrowingCallbackWithInvalidArgumentCount() {
		Assert::exception(
			function() {
				(new Iteration\Filtered(
					new Iteration\Hash([1, 2, 3, 'string']),
					new Condition\Callback(
						function($value, $invalid) {
							return is_string($value) && is_numeric($invalid);
						}
					)
				))->product();
			},
			\UnexpectedValueException::class,
			'Callback must have single argument and boolean return type'
		);
	}

	public function testThrowingCallbackWithInvalidReturnType() {
		Assert::error(
			function() {
				(new Iteration\Filtered(
					new Iteration\Hash([1, 2, 3, 'string']),
					new Condition\Callback(
						function($value) {
							return (string) $value;
						}
					)
				))->product();
			},
			\UnexpectedValueException::class,
			'Callback must have single argument and boolean return type'
		);
	}
}

(new Filtered())->run();
