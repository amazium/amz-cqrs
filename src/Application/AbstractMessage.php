<?php

namespace Amz\Cqrs\Application;

use Amz\Core\Contracts\Extractable;
use Amz\Core\IO\Context;
use Amz\Core\IO\Context\ContextCollection;
use Amz\Core\Contracts\Identifiable;
use Amz\Core\Contracts\Named;
use Amz\Core\Contracts\Traits\InjectTextualIdentifier;
use DateTime;
use Ramsey\Uuid\Uuid;

abstract class AbstractMessage implements Identifiable, Named, Extractable
{
    use InjectTextualIdentifier;

    /** @var Extractable */
    protected $payload;

    /** @var DateTime */
    private $createdAt;

    /** @var ContextCollection */
    private $context;

    /**
     * AbstractMessage constructor.
     * @param mixed $payload
     * @param string|null $id
     * @param string $createdAt
     * @throws \Exception
     */
    public function __construct(Extractable $payload, string $id = null, string $createdAt = 'now')
    {
        $this->payload = $payload;
        $this->id = $id ?: Uuid::uuid4()->toString();
        $this->createdAt = new DateTime($createdAt);
        $this->context = new ContextCollection();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return get_class($this->payload);
    }

    /**
     * @return DateTime
     */
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $key
     * @return Context
     */
    public function context(string $key = null): ?Context
    {
        if (is_null($key)) {
            return $this->context;
        }
        if (!$this->context->offsetExists($key)) {
            return null;
        }
        return $this->context->offsetGet($key);
    }

    /**
     * @param string $key
     * @param Context $context
     * @return void
     */
    public function addContext(string $key, Context $context): void
    {
        $this->context->offsetSet($key, $context);
    }

    public function getArrayCopy(array $options = []): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name(),
            'payload' => $this->payload,
            'context' => $this->context,
        ];
    }
}
