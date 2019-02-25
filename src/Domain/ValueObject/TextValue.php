<?php

namespace Amz\Cqrs\Domain\ValueObject;

abstract class TextValue implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
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
        return $this->value;
    }
}
