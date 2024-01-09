<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataRepository;

/**
 * Interface DataRepositoryInterface
 * 
 * @package Cherry
 * @subpackage BakeORM\DataRepository
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface DataRepositoryInterface
{
    /**
     * Finds a single record by its ID
     * 
     * @param int $id The ID of the record
     * @return array The record
     */
    public function find(int $id): array;

    /**
     * Finds all records
     * 
     * @return array The records
     */
    public function findAll(): array;

    /**
     * Finds records by conditions
     * 
     * @param array $selectors (Optional) The selectors
     * @param array $conditions (Optional) The conditions
     * @param array $params (Optional) The parameters
     * @param array $optional (Optional) The optional
     * @return array The records
     */
    public function findBy(
        array $selectors = [],
        array $conditions = [],
        array $params = [],
        array $optional = []
    ): array;

    /**
     * Finds a single record by conditions
     * 
     * @param array $conditions The conditions
     * @return array The record
     */
    public function findOneBy(array $conditions): array;

    /**
     * Finds an object by conditions
     * 
     * @param array $conditions (Optional) The conditions
     * @param array $selectors (Optional) The selectors
     * @return object The object
     */
    public function findObjectBy(array $conditions = [], array $selectors = []): object;

    /**
     * Find items by search criteria.
     *
     * @param array $selectors (Optional) Array of selectors.
     * @param array $conditions (Optional) Array of conditions.
     * @param array $params (Optional) Array of parameters.
     * @param array $optional (Optional) Array of optional parameters.
     * @return array The found items.
     */
    public function findBySearch(
        array $selectors = [],
        array $conditions = [],
        array $params = [],
        array $optional = []
    ): array;

    /**
     * Find items by search criteria and delete.
     * 
     * @param array $conditions The conditions
     * @param int $id The ID
     * @return bool The result
     */
    public function findByIdAndDelete(array $conditions, int $id): bool;

    /**
     * Find items by search criteria and update.
     * 
     * @param array $fields (Optional) The conditions
     * @param int $id The ID
     * @return bool The result
     */
    public function findByIdAndUpdate(array $fields = [], int $id): bool;

    /**
     * Find items with search and paging.
     * 
     * @param array $args The arguments
     * @param object $request The request
     * @return array The found items
     */
    public function findWithSearchAndPaging(array $args, object $request): array;

    /**
     * Find and return a single record
     * 
     * @param int $id The ID
     * @param array $selectors (Optional) The selectors
     * @return self The instance
     */
    public function findAndReturn(int $id, array $selectors = []): self;
}