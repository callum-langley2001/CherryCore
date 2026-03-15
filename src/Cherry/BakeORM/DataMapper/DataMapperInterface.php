<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

interface DataMapperInterface
{
    /**
     * Prepare the query string
     *
     * @param string $sqlQuery
     * @return self
     */
    public function prepare(string $sqlQuery): self;

    /**
     * Bind values
     *
     * @param mixed $value
     * @return mixed
     */
    public function bind(mixed $value): mixed;

    /**
     * Bind parameters
     *
     * @param array   $fields
     * @param boolean $isSearch
     * @return mixed
     */
    public function bindParameters(array $fields, bool $isSearch = false): mixed;

    /**
     * Get the number of rows
     *
     * @return int
     */
    public function numRows(): int;

    /**
     * Execute the query
     */
    public function execute();

    /**
     * Fetch a single result
     *
     * @return ?object
     */
    public function result(): ?object;

    /**
     * Fetch all results
     *
     * @return array[object]
     */
    public function results(): array;

    /**
     * Get the last inserted id
     *
     * @return int
     */
    public function getLastId(): int;
}
