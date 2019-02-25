<?php

namespace Amz\Cqrs\Domain\Aggregate;

class AggregateRoot
{
    /**
     * @var array
     */
    private $_changes = [];

    private $_id;

    private $_version;

    public function uncommittedChanges(): array
    {
        return $this->_changes;
    }

    public function markChangesAsCommitted()
    {
        $this->_changes = [];
    }

    public function loadsFromHistory(array $events)
    {
        foreach ($events as $event) {
            $this->applyChange($event, false);
        }
    }

    public function applyChange($event, bool $isNew = false)
    {
        $this->apply($event);
        if ($isNew) {
            $this->_changes[] = $event;
        }
    }
}
