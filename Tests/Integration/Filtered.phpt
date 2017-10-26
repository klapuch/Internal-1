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

	public function testFilteringValuesByAllCallbacks() {
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

	public function testFilteringValuesByOneOfCallbacks() {
		Assert::same(
			[1, 2, 3, 'string'],
			(new Iteration\Filtered(
				new Iteration\Hash([1, 2, 3, 'string']),
				new Condition\OneOf(
					new Condition\Callback(
						function($value): bool {
							return is_string($value);
						}
					),
					new Condition\Callback('is_int')
				)
			))->product()
		);
	}

	public function testFilteringKeysByAllCallbacks() {
		Assert::same(
			[],
			(new Iteration\Filtered(
				new Iteration\Hash(['1' => 1, '2' => 2, 'third' => '3']),
				new Condition\All(
					new Condition\Callback('is_string'),
					new Condition\Callback('is_numeric')
				),
				Iteration\Filtered::KEYS
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

	public function testFilteringBothWithByAllCallbacks() {
		Assert::same(
			[],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'first' => '1',
						'second' => '2',
						'third' => '3',
					]
				),
				new Condition\All(
					new Condition\Callback(
						function($value, $key) {
							return is_string($value) && is_string($key);
						}
					),
					new Condition\Callback(
						function($value, $key) {
							return is_numeric($value) && is_numeric($key);
						}
					)
				),
				Iteration\Filtered::BOTH
			))->product()
		);
	}

	public function testFilteringBothWithByOneOfCallbacks() {
		Assert::same(
			[
				'first' => '1',
				'second' => '2',
				'third' => '3',
			],
			(new Iteration\Filtered(
				new Iteration\Hash(
					[
						'first' => '1',
						'second' => '2',
						'third' => '3',
					]
				),
				new Condition\OneOf(
					new Condition\Callback(
						function($value, $key) {
							return is_string($value) && is_string($key);
						}
					),
					new Condition\Callback(
						function($value, $key) {
							return is_numeric($value) && is_numeric($key);
						}
					)
				),
				Iteration\Filtered::BOTH
			))->product()
		);
	}
}

(new Filtered())->run();
