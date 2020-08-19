<?php

namespace Packaged\Predicate;

use Packaged\Predicate\Abstracts\AbstractPredicate;

class GreaterThanPredicate extends AbstractPredicate
{
  public static function identifier(): string
  {
    return '>';
  }

  protected function _test($actual): bool
  {
    return $actual > $this->_expected;
  }
}
