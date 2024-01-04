<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Throwable;

/**
 * Interface DataMapperInterface
 * 
 * @package Cherry
 * @subpackage BakeORM\DataMapper
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface DataMapperInterface
{
    /**
     * Prepares the query for execution.
     * Creates a database connection and prepares the query.
     * 
     * @param string $sql The query to prepare
     * @return self The DataMapper instance
     */
    public function prepare(string $sql): self;

    /**
     * Binds a value to a parameter in the query
     * 
     * @param mixed $value The value to bind
     * @return mixed The bound value
     */
    public function bind(mixed $value): mixed;

    /**
     * Binds parameters to the query
     * 
     * @param array $fields The fields to bind
     * @param bool $isSearch (Optional) Whether the query is a search
     * @return self|bool The DataMapper instance or false if the fields are empty
     */
    public function bindParams(array $fields, bool $isSearch = false): self|bool;

    /**
     * Returns the number of rows in the result
     * 
     * @return int The number of rows
     */
    public function numRows(): int;

    /**
     * Executes the query
     * 
     * @return void 
     */
    public function execute(): bool;

    /**
     * Returns the result of the query
     * 
     * @return object The result
     */
    public function result(): object;

    /**
     * Returns the results of the query as an array
     * 
     * @return array The results
     */
    public function results(): array;

    /**
     * Returns the last inserted ID
     * 
     * @return int The last inserted ID
     * @throws Throwable
     */
    public function getLastID(): int;
}
