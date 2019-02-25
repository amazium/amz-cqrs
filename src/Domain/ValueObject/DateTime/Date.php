<?php

namespace Amz\Cqrs\Domain\ValueObject\DateTime;

use DateTime as SplDateTime;

class Date extends DateTime
{
    /**
     * Date constructor.
     * @param SplDateTime $value
     */
    public function __construct(SplDateTime $value)
    {
        $value->setTime(0, 0, 0);
        parent::__construct($value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value()->format('Y-m-d');
    }
}
