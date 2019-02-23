<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Contracts\Extractable;
use Amz\Cqrs\Application\AbstractMessage;

class CommandMessage extends AbstractMessage
{
    /**
     * CommandMessage constructor.
     * @param Command $command
     * @param string|null $id
     * @param string $createdAt
     * @throws \Exception
     */
    public function __construct(Command $command, string $id = null, string $createdAt = 'now')
    {
        parent::__construct($command, $id, $createdAt);
    }

    /**
     * @return Extractable
     */
    public function command(): Extractable
    {
        return $this->payload;
    }
}
