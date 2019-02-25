<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Contracts\CreatableFromArray;
use Amz\Core\Contracts\Extractable;
use Amz\Core\Contracts\Identifiable;

interface Command extends Extractable, CreatableFromArray, Identifiable
{

}
