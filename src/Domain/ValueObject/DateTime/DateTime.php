<?php

namespace Amz\Cqrs\Domain\ValueObject\DateTime;

use Amz\Cqrs\Domain\ValueObject\ValueObject;
use DateTime as SplDateTime;

class DateTime implements ValueObject
{
    /**
     * @var SplDateTime
     */
    private $value;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(SplDateTime $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $dateTime): DateTime
    {
        return new static(new SplDateTime($dateTime));
    }

    /**
     * @return SplDateTime
     */
    public function value(): SplDateTime
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
        return $this->value->format('Y-m-d H:i:s');
    }
}
