<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Dasuos\Internal\Integration;

use Dasuos\Internal\Condition;
use Dasuos\Internal\Iteration;
use Dasuos\Internal\Task;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Iterations extends \Tester\TestCase {

	public function testFilteringAndMappingValues() {
		Assert::same(
			[3 => 'FOO', 4 => 'BAR'],
			(new Iteration\Mapped(
				new Task\Callback('strtoupper'),
				new Iteration\Filtered(
					new Iteration\Hash([1, 2, 3, 'foo', 'bar']),
					new Condition\Callback('is_string')
				)
			))->product()
		);
	}

	public function testFilteringWithOneOfConditionAndMappingValues() {
		Assert::same(
			[
				0 => '1',
				1 => '2',
				2 => '3',
				3 => 'foo',
				4 => 'bar',
			],
			(new Iteration\Mapped(
				new Task\Callback('strval'),
				new Iteration\Filtered(
					new Iteration\Hash([1, 2, 3, 'foo', 'bar', true]),
					new Condition\OneOf(
						new Condition\Callback('is_string'),
						new Condition\Callback('is_int')
					)
				)
			))->product()
		);
	}

	public function testFilteringWithAllConditionsAndMappingValues() {
		Assert::same(
			[0 => '1', 1 => '2', 2 => '3'],
			(new Iteration\Mapped(
				new Task\Callback('strval'),
				new Iteration\Filtered(
					new Iteration\Hash(['1', '2', '3', 'foo', 'bar', true]),
					new Condition\All(
						new Condition\Callback('is_string'),
						new Condition\Callback('is_numeric')
					)
				)
			))->product()
		);
	}

}

(new Iterations())->run();