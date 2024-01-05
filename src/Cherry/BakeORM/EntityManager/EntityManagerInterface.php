<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

/**
 * Interface EntityManagerInterface
 * 
 * @package Cherry
 * @subpackage BakeORM\EntityManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface EntityManagerInterface
{
    /**
     * Get the CRUD object
     * 
     * @return object
     */
    public function getCrud(): object;
}
