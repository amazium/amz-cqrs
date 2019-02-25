<?php

namespace Amz\Cqrs\Domain\ValueObject;

use Amz\Cqrs\Domain\ValueObject\Exception\InvalidValueForEnumException;

abstract class Enum implements ValueObject
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @return array
     */
    abstract protected function allowedValues(): array;

    /**
     * Enum constructor.
     * @param string $value
     * @throws InvalidValueForEnumException
     */
    public function __construct($value)
    {
        if (!in_array($value, $this->allowedValues())) {
            throw InvalidValueForEnumException::withValue(static::class, self::allowedValues(), $value);
        }
        $this->value = $value;
    }

    /**
     * @return mixed|string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other): bool
    {
        return $this->value === $other->value();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return strval($this->value);
    }

}
