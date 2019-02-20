<?php

namespace Amz\Cqrs\Application;

use Amz\Core\Application\Context\Context;
use Amz\Core\Application\Context\ContextCollection;
use Amz\Core\Contracts\Identifiable;
use Amz\Core\Contracts\Nameable;
use Amz\Core\Contracts\Traits\InjectTextualIdentifier;
use DateTime;
use Ramsey\Uuid\Uuid;

abstract class AbstractMessage implements Identifiable, Nameable
{
    use InjectTextualIdentifier;

    /** @var mixed */
    protected $payload;

    /** @var DateTime */
    private $createdAt;

    /** @var ContextCollection */
    private $context;

    public function __construct($payload, string $id = null, string $createdAt = 'now')
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
    public function context(string $key): Context
    {
        if (!$this->context->offsetExists($key)) {
            return null;
        }
        return $this->context->offsetGet($key);
    }

    /**
     * @param string $key
     * @param Context $context
     */
    public function addContext(string $key, Context $context)
    {
        $this->context->offsetSet($key, $context);
    }

}
