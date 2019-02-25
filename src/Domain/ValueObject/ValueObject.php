<?php

namespace Amz\Cqrs\Domain\ValueObject;

interface ValueObject
{
    /**
     * @return mixed
     */
    public function value();

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @param mixed $other
     * @return bool
     */
    public function equals(ValueObject $other): bool;
}
