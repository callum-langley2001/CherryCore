<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder;

use Cherry\BakeORM\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;
use Cherry\BakeORM\QueryBuilder\QueryBuilderInterface;

/**
 * QueryBuilderFactory class
 * This class is used to create QueryBuilder objects.
 * 
 * @package Cherry
 * @subpackage BakeORM\QueryBuilder
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class QueryBuilderFactory
{
    public function __construct()
    {
    }

    /**
     * Creates a new instance of a QueryBuilderInterface based on the given string.
     *
     * @param string $queryBuilderString The fully qualified class name of the query builder.
     * @throws QueryBuilderInvalidArgumentException If the provided query builder string does not implement the QueryBuilderInterface interface.
     * @return QueryBuilderInterface The newly created query builder object.
     */
    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = (new $queryBuilderString());

        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderInvalidArgumentException("{$queryBuilderString} is not a valid query builder object.");
        }

        return $queryBuilderObject;
    }
}
