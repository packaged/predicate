<?php

namespace Packaged\Predicate;

use Packaged\Predicate\Abstracts\AbstractPredicate;

class InPredicate extends AbstractPredicate
{
  public static function identifier(): string
  {
    return 'in';
  }

  protected function _test($actual): bool
  {
    return in_array($actual, $this->_expected);
  }
}
