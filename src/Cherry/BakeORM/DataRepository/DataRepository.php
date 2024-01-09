<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataRepository;

use Cherry\BakeORM\DataRepository\Exception\DataRepositoryInvalidArgumentException;
use Cherry\BakeORM\DataRepository\DataRepositoryInterface;
use Cherry\BakeORM\EntityManager\EntityManagerInterface;
use Throwable;

/**
 * DataRepository class
 * 
 * @package Cherry
 * @subpackage BakeORM\DataRepository
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements DataRepositoryInterface
 * @see DataRepositoryInterface
 */
class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    /**
     * Creates a new instance of the class.
     *
     * @param EntityManagerInterface $em the entity manager interface
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Checks if the given value is an array.
     *
     * @param array $conditions The value to be checked.
     * @throws DataRepositoryInvalidArgumentException If the argument is not an array.
     * @return void
     */
    private function isArray(array $conditions): void
    {
        if (!is_array($conditions)) {
            throw new DataRepositoryInvalidArgumentException('The argument must be an array.');
        }
    }

    /**
     * Checks if the given id is empty.
     *
     * @param int $id The id to check.
     * @throws DataRepositoryInvalidArgumentException If the id is empty.
     * @return void
     */
    private function isEmpty(int $id): void
    {
        if (empty($id)) {
            throw new DataRepositoryInvalidArgumentException('The id cannot be empty.');
        }
    }

    /**
     * Find an item by its ID.
     *
     * @param int $id The ID of the item to find.
     * @throws Throwable If an error occurs while finding the item.
     * @return array The found item.
     */
    public function find(int $id): array
    {
        $this->isEmpty($id);

        try {
            return $this->findOneBy(['id' => $id]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Retrieves all records from the database.
     *
     * @throws Throwable when an error occurs while retrieving the records.
     * @return array An array containing all the retrieved records.
     */
    public function findAll(): array
    {
        try {
            return $this->em->getCrud()->read();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Retrieves an array of entities based on the provided selectors, conditions, parameters, and optional arguments.
     *
     * @param array $selectors An array of selectors used to filter the entities
     * @param array $conditions An array of conditions used to filter the entities
     * @param array $params An array of parameters used in the query
     * @param array $optional An array of optional arguments
     * @throws Throwable If an error occurs while retrieving the entities
     * @return array An array of entities that match the specified criteria
     */
    public function findBy(
        array $selectors = [],
        array $conditions = [],
        array $params = [],
        array $optional = []
    ): array {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $params, $optional);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find one record in the database based on the given conditions.
     *
     * @param array $conditions The conditions to search for.
     * @throws Throwable An exception that occurred during the operation.
     * @return array The retrieved record.
     */
    public function findOneBy(array $conditions): array
    {
        $this->isArray($conditions);

        try {
            return $this->em->getCrud()->read([], $conditions);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function findObjectBy(array $conditions = [], array $selectors = []): object
    {
    }

    /**
     * Retrieves an array of records based on search criteria.
     *
     * @param array $selectors (Optional) An array of fields to select from the records.
     * @param array $conditions (Optional) An array of conditions to filter the records.
     * @param array $params (Optional) Additional parameters for the search.
     * @param array $optional (Optional) parameters for the search.
     * @throws Throwable If an exception occurs during the search.
     * @return array An array of records that match the search criteria.
     */
    public function findBySearch(
        array $selectors = [],
        array $conditions = [],
        array $params = [],
        array $optional = []
    ): array {
        $this->isArray($conditions);

        try {
            return $this->em->getCrud()->search($selectors, $conditions, $params, $optional);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Finds and deletes a record based on the given conditions.
     *
     * @param array $conditions The conditions used to find the record.
     * @param mixed $id The ID of the record.
     * @throws Throwable If an error occurs while finding or deleting the record.
     * @return bool Returns true if the record is found and deleted successfully, false otherwise.
     */
    public function findByIdAndDelete($conditions, $id): bool
    {
        $this->isArray($conditions);

        try {
            $result = $this->findOneBy($conditions);
            if (
                $result != null
                && count($result) > 0
            ) {
                $delete = $this->em->getCrud()->delete($conditions);
                if ($delete) return true;
            }
            return false;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Find a record by ID and update its fields.
     *
     * @param array $fields (Optional) The fields to update
     * @param int $id The ID of the record to update
     * @throws Throwable If an error occurs during the update
     * @return bool Returns true if the update was successful, false otherwise
     */
    public function findByIdAndUpdate(array $fields = [], int $id): bool
    {
        $this->isArray($fields);

        try {
            $result = $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);
            if (
                $result != null
                && count($result) > 0
            ) {
                $params = (!empty($fields)) ? array_merge([$this->em->getCrud()->getSchemaID() => $id], $fields) : $fields;
                $update = $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaID());
                if ($update) return true;
            }
            return false;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function findBySearchAndPaging(array $args, object $request): array
    {
        return [];
    }

    public function findAndReturn(int $id, array $selectors = []): self
    {

        return $this;
    }
}
