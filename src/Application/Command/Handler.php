<?php

namespace Amz\Cqrs\Application\Command;

interface Handler
{
    /**
     * @param CommandMessage $message
     * @return CommandResult
     */
    public function handle(CommandMessage $message): CommandResult;
}
