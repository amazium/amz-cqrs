<?php

namespace Amz\Cqrs\Application\Command;

interface Handler
{
    /**
     * @param CommandMessage $message
     * @return Result
     */
    public function handle(CommandMessage $message): Result;
}
