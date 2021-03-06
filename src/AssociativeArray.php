<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

class AssociativeArray extends ArrayObject implements IAssociativeArray
{
    use TAssociativeArray;
}