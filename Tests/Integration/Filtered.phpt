<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Integration;

use Dasuos\Internal\Condition;
use Dasuos\Internal\Iteration;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Filtered extends \Tester\TestCase {

	public function testFilteringValuesByNamedFunction() {
		Assert::same(
			[1, 2, 3],
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback('is_numeric')
			))->product()
		);
	}

	public function testFilteringKeysByNamedFunction() {
		Assert::same(
			['1' => 'first', '2' => 'second'],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'1' => 'first',
						'2' => 'second',
						'string' => 'third',
					]
				),
				new Condition\Callback('is_numeric'),
				Iteration\Filtered::KEYS
			))->product()
		);
	}

	public function testFilteringValuesByAnonymousFunction() {
		Assert::same(
			[3 => 'string'],
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\Callback(
					function($value): bool {
						return is_string($value);
					}
				)
			))->product()
		);
	}

	public function testFilteringKeysByAnonymousFunction() {
		Assert::same(
			['1' => 'first', '2' => 'second'],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'1' => 'first',
						'2' => 'second',
						'string' => 'third',
					]
				),
				new Condition\Callback(
					function($key): bool {
						return is_numeric($key);
					}
				),
				Iteration\Filtered::KEYS
			))->product()
		);
	}

	public function testFilteringBothByAnonymousFunction() {
		Assert::same(
			['1' => 1, '2' => 2],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'1' => 1,
						'2' => 2,
						'third' => 3,
					]
				),
				new Condition\Callback(
					function($value, $key): bool {
						return is_numeric($key) && is_int($value);
					}
				),
				Iteration\Filtered::BOTH
			))->product()
		);
	}

	public function testFilteringValuesByCombinedCallbacks() {
		Assert::same(
			[],
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\All(
					new Condition\Callback(
						function($value): bool {
							return is_string($value);
						}
					),
					new Condition\Callback('is_numeric')
				)
			))->product()
		);
	}

	public function testFilteringKeysByOneOfCallbacks() {
		Assert::same(
			['1' => 1, '2' => 2, 'third' => '3'],
			(new Iteration\Filtered(
				new Iteration\Hash(['1' => 1, '2' => 2, 'third' => '3']),
				new Condition\OneOf(
					new Condition\Callback('is_string'),
					new Condition\Callback('is_numeric')
				),
				Iteration\Filtered::KEYS
			))->product()
		);
	}

	public function testFilteringValuesWithNamedKeysByCombinedCallbacks() {
		Assert::same(
			['third' => 3],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'first' => 1,
						'second' => 2,
						'third' => 3,
					]
				),
				new Condition\All(
					new Condition\Callback('is_integer'),
					new Condition\Callback(
						function(int $value): bool {
							return $value === 3;
						}
					)
				)
			))->product()
		);
	}

	public function testThrowingCallbackWithInvalidArgumentCount() {
		Assert::error(
			function() {
				(new Iteration\Filtered(
					new Iteration\Hash([1, 2, 3, 'string']),
					new Condition\Callback(
						function($value, $invalid): bool {
							return is_string($value) && is_numeric($invalid);
						}
					)
				))->product();
			},
			\TypeError::class
		);
	}

	public function testFilteringValuesByCallbackWithNoBooleanReturnType() {
		Assert::same(
			['foo@bar.cz'],
			(new Iteration\Filtered(
				new Iteration\Hash(['foo@bar.cz', 'foo']),
				new Condition\Callback(
					function($value) {
						return filter_var($value, FILTER_VALIDATE_EMAIL);
					}
				)
			))->product()
		);
	}
}

(new Filtered())->run();
