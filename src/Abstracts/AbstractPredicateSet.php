<?php

namespace Packaged\Predicate\Abstracts;

use Packaged\Predicate\Interfaces\Predicate;
use Packaged\Predicate\Predicates;

abstract class AbstractPredicateSet extends AbstractPredicate
{
  public function expect($predicates)
  {
    if(!is_array($predicates))
    {
      $this->_throwInvalidExpectedValue('Predicate set must only expect an array of predicates');
    }
    foreach($predicates as $pred)
    {
      if(!$pred instanceof Predicate)
      {
        $this->_throwInvalidExpectedValue('Predicate set must only expect an array of predicates');
      }
    }
    return parent::expect($predicates);
  }

  public function deserialize(array $predicates)
  {
    foreach($predicates['expect'] as $k => $predicate)
    {
      $predicates['expect'][$k] = Predicates::getPredicate($predicate['predicate'])->deserialize($predicate);
    }
    return parent::deserialize($predicates);
  }
}
