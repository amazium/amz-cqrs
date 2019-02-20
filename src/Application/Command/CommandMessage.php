<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Cqrs\Application\AbstractMessage;

class CommandMessage extends AbstractMessage
{
    /**
     * CommandMessage constructor.
     * @param Command $command
     * @param string|null $id
     * @param string $createdAt
     */
    public function __construct(Command $command, string $id = null, string $createdAt = 'now')
    {
        parent::__construct($command, $id, $createdAt);
    }

    /**
     * @return Command
     */
    public function command(): Command
    {
        return $this->payload;
    }
}
