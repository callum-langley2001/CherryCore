<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder;

use Cherry\BakeORM\QueryBuilder\QueryBuilder;
use Cherry\BakeORM\QueryBuilder\QueryBuilderInterface;
use Cherry\BakeORM\QueryBuilder\Exception\QueryBuilderException;

class QueryBuilderFactory
{

    public function __construct() {}

    /**
     * Creates a query builder object based on the given string.
     *
     * This method creates a query builder object based on the given string.
     * If the given query builder string is not a valid query builder object, a QueryBuilderException will be thrown.
     *
     * @param string $queryBuilderString The query builder string to create an object from
     * @return QueryBuilderInterface The created query builder object
     * @throws QueryBuilderException If the given query builder string is not a valid query builder object
     */
    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();

        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderException("$queryBuilderString is not a valid query builder object");
        }

        return $queryBuilderObject;
    }
}
