<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Cherry\BakeORM\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface
{

    /**
     * The crud object
     * @var CrudInterface $crud
     */
    protected CrudInterface $crud;

    /**
     * Initializes the EntityManager object with the given Crud object.
     *
     * @param CrudInterface $crud The Crud object to use
     */
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    /**
     * Gets the Crud object used by the EntityManager.
     *
     * @return CrudInterface The Crud object used by the EntityManager
     */
    public function getCrud(): CrudInterface
    {
        return $this->crud;
    }
}
