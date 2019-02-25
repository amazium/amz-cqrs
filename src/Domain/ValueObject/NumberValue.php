<?php

namespace Amz\Cqrs\Domain\ValueObject;

abstract class NumberValue implements ValueObject
{
    /**
     * @var int
     */
    private $value;

    /**
     * IntValue constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
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
