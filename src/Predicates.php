<?php

namespace Packaged\Predicate;

use Packaged\Predicate\Interfaces\Predicate;

class Predicates
{
  public static $predicates = [
    EqualPredicate::class,
    InPredicate::class,

    GreaterThanPredicate::class,
    LessThanPredicate::class,

    AndPredicateSet::class,
    OrPredicateSet::class,
  ];

  public static function fromArray(array $data): ?Predicate
  {
    return static::getPredicate($data['predicate'])->deserialize($data);
  }

  public static function deserialize(string $serialized): ?Predicate
  {
    $data = json_decode($serialized, true);
    return static::fromArray($data);
  }

  public static function getPredicate($identifier): ?Predicate
  {
    foreach(static::$predicates as $predicate)
    {
      /** @var Predicate $predicate */
      if($predicate::identifier() === $identifier)
      {
        return new $predicate;
      }
    }
    return null;
  }
}
