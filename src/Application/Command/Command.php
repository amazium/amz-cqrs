<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Contracts\CreatableFromArray;
use Amz\Core\Contracts\Extractable;

interface Command extends Extractable, CreatableFromArray
{

}
