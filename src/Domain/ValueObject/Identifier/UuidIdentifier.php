<?php

namespace Amz\Cqrs\Domain\ValueObject\Identifier;

use Amz\Cqrs\Domain\ValueObject\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidIdentifier implements Identifier
{
    /**
     * @var UuidInterface
     */
    private $value;

    /**
     * UuidIdentifier constructor.
     * @param UuidInterface $identifier
     */
    public function __construct(UuidInterface $identifier)
    {
        $this->value = $identifier;
    }

    /**
     * @return UuidInterface
     */
    public function value(): UuidInterface
    {
        return $this->value;
    }

    /**
     * @return Identifier
     * @throws \Exception
     */
    public static function generate(): Identifier
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @param string $uuid
     * @return Identifier
     */
    public static function fromString(string $uuid): Identifier
    {
        return new static(Uuid::fromString($uuid));
    }

    /**
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other): bool
    {
        return $this === $other;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value->toString();
    }
}
