<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder\Enums;

enum QueryTypesEnum: string
{
    case INSERT = 'insert';
    case SELECT = 'select';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case RAW = 'raw';
}
