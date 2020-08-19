<?php

namespace Packaged\Predicate\Interfaces;

use Packaged\Predicate\Exceptions\InvalidValueException;

interface Predicate
{
  public static function identifier(): string;

  /**
   * @param mixed $value
   *
   * @throws InvalidValueException
   */
  public function expect($value);

  public function test($actual): bool;

  public function deserialize(array $data);
}
