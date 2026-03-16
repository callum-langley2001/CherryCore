<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataRepository;

use Cherry\BakeORM\DataRepository\DataRepositoryInterface;
use Cherry\BakeORM\DataRepository\Exception\DataRepositoryInvalidArgumentException;
use Cherry\BakeORM\EntityManager\EntityManagerInterface;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
    /**
     * The entity manager
     *
     * @var EntityManagerInterface $em
     */
    protected EntityManagerInterface $em;

    /**
     * Initializes the DataRepository object with the given EntityManager.
     *
     * @param EntityManagerInterface $em The EntityManager to use
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function find(int $id): array
    {
        $this->isEmpty($id);
        try {
            return $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findAll(): array
    {
        try {
            return $this->em->getCrud()->read();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findOneBy(array $conditions): array
    {
        $this->isArray($conditions);

        try {
            return $this->em->getCrud()->read(conditions: $conditions);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findObjectBy(array $conditions = [], array $selectors = []): object
    {
        return $this;
    }

    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        $this->isArray($conditions);

        try {
            return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findByIdAndDelete(array $conditions): bool
    {
        $this->isArray($conditions);

        try {
            $result = $this->findOneBy($conditions);

            if ($result != null && count($result) > 0) {
                $delete = $this->em->getCrud()->delete($conditions);

                if ($delete) return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
        return false;
    }

    public function findByIdAndUpdate(array $fields = [], int $id): bool
    {
        $this->isArray($fields);

        try {
            $result = $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);

            if ($result != null && count($result) > 0) {
                $params = (!empty($fields)) ? array_merge([$this->em->getCrud()->getSchemaID() => $id], $fields) : $fields;
                $update = $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaID());

                if ($update) return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
        return false;
    }

    public function findWithSearchAndPaging(array $arguments = [], object $request): array
    {
        return [];
    }

    public function findAndReturn(int $id, array $selectors = []): self
    {
        return $this;
    }

    /**
     * Checks if the given value is an array and throws a DataRepositoryInvalidArgumentException if it is not.
     *
     * @param array $conditions The value to check
     * @throws DataRepositoryInvalidArgumentException If the given value is not an array
     */
    private function isArray(array $conditions): void
    {
        if (!is_array($conditions))
            throw new DataRepositoryInvalidArgumentException("The argument {$conditions} must be an array.");
    }

    /**
     * Throws a DataRepositoryInvalidArgumentException if the given value is empty.
     *
     * This method checks if the given value is empty.
     * If the given value is empty, the method will throw a DataRepositoryInvalidArgumentException.
     *
     * @param int $id The value to check
     * @throws DataRepositoryInvalidArgumentException If the given value is empty
     */
    private function isEmpty(int $id): void
    {
        if (empty($id))
            throw new DataRepositoryInvalidArgumentException("The argument {$id} must not be empty.");
    }
}
