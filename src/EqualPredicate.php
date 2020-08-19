<?php

namespace Packaged\Predicate;

use Packaged\Predicate\Abstracts\AbstractPredicate;

class EqualPredicate extends AbstractPredicate
{
  public static function identifier(): string
  {
    return '=';
  }

  protected function _test($actual): bool
  {
    return $this->_expected === $actual;
  }
}
