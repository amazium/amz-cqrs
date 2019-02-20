<?php

namespace Amz\Cqrs\Application\Context;

use Amz\Core\Object\Collection;

class ContextCollection extends Collection
{
    /**
     * @return string
     */
    public function elementClass(): string
    {
        return Context::class;
    }
}