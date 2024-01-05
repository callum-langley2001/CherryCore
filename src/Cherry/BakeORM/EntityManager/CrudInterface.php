<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

/**
 * Interface CrudInterface
 * 
 * @package Cherry
 * @subpackage BakeORM\EntityManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface CrudInterface
{
    /**
     * Get the schema name
     * (Table name e.g. `users`)
     * 
     * @return string The name of the table
     */
    public function getSchema(): string;

    /**
     * Get the schema ID
     * (Table primary key e.g. `id`)
     * 
     * @return string The ID of the table
     */
    public function getSchemaID(): string;

    /**
     * Get the last inserted ID
     * 
     * @return int The last inserted ID
     */
    public function lastID(): int;

    /**
     * Create a new record
     * 
     * @param array $fields The fields to insert
     * @return bool True on success, false on failure
     */
    public function create(array $fields): bool;

    /**
     * Read records from the database 
     * 
     * @param array $selectors (Optional) The fields to select
     * @param array $conditions (Optional) The conditions to select
     * @param array $parameters (Optional) The parameters to select
     * @param array $optional (Optional) Additional options
     * @return array The records
     */
    public function read(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array;

    /**
     * Update a record in the database
     * 
     * @param array $fields (Optional) The fields to update
     * @param string $primaryKey The primary key
     * @return bool True on success, false on failure
     */
    public function update(array $fields = [], string $primaryKey): bool;

    /**
     * Delete a record in the database
     * 
     * @param array $conditions (Optional) The conditions
     * @return bool True on success, false on failure
     */
    public function delete(array $conditions = []): bool;

    /**
     * Search for records in the database
     * 
     * @param array $selectors (Optional) The fields to select
     * @param array $conditions (Optional) The conditions
     * @return array The records
     */
    public function search(array $selectors = [], array $conditions = []): array;

    /**
     * Run a raw query
     * 
     * @param string $sql
     * @param array|null $conditions (Optional) The conditions
     * @return ?
     */
    public function rawQuery(string $sql, ?array $conditions = []);
}
