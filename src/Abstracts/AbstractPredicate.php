<?php

namespace Packaged\Predicate\Abstracts;

use JsonSerializable;
use Packaged\Predicate\Exceptions\InvalidValueException;
use Packaged\Predicate\Interfaces\Predicate;

abstract class AbstractPredicate implements Predicate, JsonSerializable
{
  protected $_expected;
  protected $_negate;

  public static function i($expected = null)
  {
    $o = new static();
    if($expected !== null)
    {
      $o->expect($expected);
    }
    return $o;
  }

  public function expect($value)
  {
    $this->_expected = $value;
    return $this;
  }

  public function negate(bool $bool = true)
  {
    $this->_negate = $bool;
    return $this;
  }

  abstract protected function _test($actual): bool;

  final public function test($actual): bool
  {
    return $this->_test($actual) xor $this->_negate;
  }

  public function deserialize(array $data)
  {
    $this->expect($data['expect'] ?? null);
    $this->negate($data['negate'] ?? false);
    return $this;
  }

  public function jsonSerialize()
  {
    $data = [
      'predicate' => static::identifier(),
      'expect'    => $this->_expected,
    ];
    if($this->_negate)
    {
      $data['negate'] = (bool)$this->_negate;
    }
    return $data;
  }

  public function __toString()
  {
    return json_encode($this);
  }

  protected function _throwInvalidExpectedValue($message)
  {
    throw new InvalidValueException($message);
  }
}
