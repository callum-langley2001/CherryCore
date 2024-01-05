<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Cherry\BakeORM\EntityManager\CrudInterface;

/**
 * EntityManager class
 * 
 * @package Cherry
 * @subpackage BakeORM\EntityManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements EntityManagerInterface
 * @see EntityManagerInterface
 */
class EntityManager implements EntityManagerInterface
{
    /**
     * The CRUD object.
     * 
     * @var CrudInterface $crud the CRUD interface
     */
    protected CrudInterface $crud;

    /**
     * Constructs a new instance of the class.
     *
     * @param CrudInterface $crud the CRUD interface
     */
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    /**
     * Retrieves the CRUD object.
     *
     * @return object The CRUD object.
     */
    public function getCrud(): object
    {
        return $this->crud;
    }
}
