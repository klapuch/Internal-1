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

	public function testFilteringValuesByNamedFunction() {
		Assert::equal(
			new Iteration\Hash([1, 2, 3]),
			(new Iteration\Filtered(
				Iteration\Filtered::VALUES,
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback('is_numeric')
			))->product()
		);
	}

//	public function testFilteringKeysByNamedFunction() {
//		Assert::equal(
//			new Iteration\Hash(['1' => 'first', '2' => 'second']),
//			(new Iteration\Filtered(
//				Iteration\Filtered::KEYS,
//				new Iteration\Hash(
//					[
//						'1' => 'first',
//						'2' => 'second',
//						'string' => 'third',
//					]
//				),
//				new Condition\Callback('is_numeric')
//			))->product()
//		);
//	}
//
//	public function testFilteringValuesByAnonymousFunction() {
//		Assert::equal(
//			new Iteration\Hash([3 => 'string']),
//			(new Iteration\Filtered(
//				Iteration\Filtered::VALUES,
//				new Iteration\Hash([1, 2, 3, 'string']),
//				new Condition\Callback(
//					function($value): bool {
//						return is_string($value);
//					}
//				)
//			))->product()
//		);
//	}
//
//	public function testFilteringKeysByAnonymousFunction() {
//		Assert::equal(
//			new Iteration\Hash(['1' => 'first', '2' => 'second']),
//			(new Iteration\Filtered(
//				Iteration\Filtered::KEYS,
//				new Iteration\Hash(
//					[
//						'1' => 'first',
//						'2' => 'second',
//						'string' => 'third',
//					]
//				),
//				new Condition\Callback(
//					function($key): bool {
//						return is_numeric($key);
//					}
//				)
//			))->product()
//		);
//	}
//
//	public function testFilteringBothByAnonymousFunction() {
//		Assert::equal(
//			new Iteration\Hash(['1' => 1, '2' => 2]),
//			(new Iteration\Filtered(
//				Iteration\Filtered::BOTH,
//				new Iteration\Hash(
//					[
//						'1' => 1,
//						'2' => 2,
//						'third' => 3,
//					]
//				),
//				new Condition\Callback(
//					function($value, $key): bool {
//						return is_numeric($key) && is_int($value);
//					}
//				)
//			))->product()
//		);
//	}
//
//	public function testFilteringValuesByCombinedCallbacks() {
//		Assert::equal(
//			new Iteration\Hash([]),
//			(new Iteration\Filtered(
//				Iteration\Filtered::VALUES,
//				new Iteration\Hash([1, 2, 3, 'string']),
//				new Condition\Callback(
//					function($value): bool {
//						return is_string($value);
//					}
//				),
//				new Condition\Callback('is_numeric')
//			))->product()
//		);
//	}
//
//	public function testFilteringKeysByCombinedCallbacks() {
//		Assert::equal(
//			new Iteration\Hash([]),
//			(new Iteration\Filtered(
//				Iteration\Filtered::KEYS,
//				new Iteration\Hash(['1' => 1, '2' => 2, 'third' => '3']),
//				new Condition\Callback('is_numeric'),
//				new Condition\Callback(
//					function($key): bool {
//						return $key > 10;
//					}
//				)
//			))->product()
//		);
//	}
//
//	public function testFilteringValuesWithNamedKeys() {
//		Assert::equal(
//			new Iteration\Hash(['third' => 3]),
//			(new Iteration\Filtered(
//				Iteration\Filtered::VALUES,
//				new Iteration\Hash(
//					[
//						'first' => 1,
//						'second' => 2,
//						'third' => 3,
//					]
//				),
//				new Condition\Callback('is_integer'),
//				new Condition\Callback(
//					function(int $value): bool {
//						return $value === 3;
//					}
//				)
//			))->product()
//		);
//	}
//
//	public function testThrowingCallbackWithInvalidArgumentCount() {
//		Assert::error(
//			function() {
//				(new Iteration\Filtered(
//					Iteration\Filtered::VALUES,
//					new Iteration\Hash([1, 2, 3, 'string']),
//					new Condition\Callback(
//						function($value, $invalid) {
//							return is_string($value) && is_numeric($invalid);
//						}
//					)
//				))->product();
//			},
//			\TypeError::class
//		);
//	}
//
//	public function testThrowingCallbackWithInvalidReturnType() {
//		Assert::exception(
//			function() {
//				(new Iteration\Filtered(
//					Iteration\Filtered::VALUES,
//					new Iteration\Hash([1, 2, 3, 'string']),
//					new Condition\Callback(
//						function($value) {
//							return (string) $value;
//						}
//					)
//				))->product();
//			},
//			\TypeError::class
//		);
//	}
}

(new Filtered())->run();
