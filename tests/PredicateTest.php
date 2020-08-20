<?php
namespace Packaged\Predicate\Tests;

use Packaged\Predicate\AndPredicateSet;
use Packaged\Predicate\EqualPredicate;
use Packaged\Predicate\GreaterThanPredicate;
use Packaged\Predicate\InPredicate;
use Packaged\Predicate\Interfaces\Predicate;
use Packaged\Predicate\LessThanPredicate;
use Packaged\Predicate\OrPredicateSet;
use Packaged\Predicate\Predicates;
use PHPUnit\Framework\TestCase;

class PredicateTest extends TestCase
{
  public function predicateIdentProvider()
  {
    return [
      ['=', EqualPredicate::class],
      ['in', InPredicate::class],

      ['>', GreaterThanPredicate::class],
      ['<', LessThanPredicate::class],

      ['or', OrPredicateSet::class],
      ['and', AndPredicateSet::class],
    ];
  }

  /**
   * @dataProvider predicateIdentProvider
   *
   * @param           $ident
   * @param Predicate $class
   */
  public function testPredicateIdent($ident, $class)
  {
    $this->assertEquals($ident, $class::identifier());
    $this->assertInstanceOf($class, Predicates::getPredicate($ident));
    $this->assertInstanceOf($class, $class::i());
  }

  public function predicateMatchProvider()
  {
    return [
      // positive tests
      [true, EqualPredicate::i(1), 1],
      [true, EqualPredicate::i(1)->negate(), 0],
      [true, GreaterThanPredicate::i(1), 2],
      [true, GreaterThanPredicate::i(1), 20],
      [true, AndPredicateSet::i([GreaterThanPredicate::i(5), LessThanPredicate::i(10)]), 6],
      [true, OrPredicateSet::i([LessThanPredicate::i(5), GreaterThanPredicate::i(10)]), 2],
      [true, OrPredicateSet::i([LessThanPredicate::i(5), GreaterThanPredicate::i(10)]), 11],

      // negative tests
      [false, EqualPredicate::i(1), 0],
      [false, EqualPredicate::i(1)->negate(), 1],
      [false, EqualPredicate::i(1), '1'],
      [false, AndPredicateSet::i([GreaterThanPredicate::i(5), LessThanPredicate::i(10)]), 4],
      [false, OrPredicateSet::i([LessThanPredicate::i(5), GreaterThanPredicate::i(10)]), 6],
      [false, OrPredicateSet::i([LessThanPredicate::i(5), GreaterThanPredicate::i(10)]), 9],
    ];
  }

  /**
   * @dataProvider predicateMatchProvider
   *
   * @param bool      $expect
   * @param Predicate $predicate
   * @param           $testValue
   */
  public function testPredicateMatching($expect, Predicate $predicate, $testValue)
  {
    $this->assertEquals($expect, $predicate->test($testValue));
  }

  public function predicateSerializeProvider()
  {
    return [
      [
        EqualPredicate::i('test'),
        '{"predicate":"=","expect":"test"}',
      ],
      [
        EqualPredicate::i('test-negate')->negate(),
        '{"predicate":"=","expect":"test-negate","negate":true}',
      ],
      [
        AndPredicateSet::i([GreaterThanPredicate::i(5), LessThanPredicate::i(10)]),
        '{"predicate":"and","expect":[{"predicate":">","expect":5},{"predicate":"<","expect":10}]}',
      ],
    ];
  }

  /**
   * @dataProvider predicateSerializeProvider
   *
   * @param Predicate $predicate
   * @param string    $serialized
   */
  public function testPredicateSerialization($predicate, $serialized)
  {
    $this->assertEquals($serialized, (string)$predicate);

    $deserialized = Predicates::deserialize($serialized);
    $this->assertEquals($serialized, (string)$deserialized);
  }
}
