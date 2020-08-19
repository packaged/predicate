<?php

namespace Packaged\Predicate;

use Packaged\Predicate\Abstracts\AbstractPredicateSet;
use Packaged\Predicate\Interfaces\Predicate;

class AndPredicateSet extends AbstractPredicateSet
{
  public static function identifier(): string
  {
    return 'and';
  }

  protected function _test($actual): bool
  {
    /** @var Predicate $pred */
    foreach($this->_expected as $pred)
    {
      if(!$pred->test($actual))
      {
        return false;
      }
    }
    return true;
  }
}
