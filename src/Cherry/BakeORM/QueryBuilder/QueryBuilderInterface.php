<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder;

/**
 * Interface QueryBuilderInterface
 * 
 * @package Cherry
 * @subpackage BakeORM\QueryBuilder
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface QueryBuilderInterface
{
    /**
     * Builds the insert query.
     *
     * @return string The insert query
     */
    public function insertQuery(): string;

    /**
     * Builds the select query.
     * 
     * @return string The select query
     */
    public function selectQuery(): string;

    /**
     * Builds the update query.
     * 
     * @return string The update query
     */
    public function updateQuery(): string;

    /**
     * Builds the delete query.
     * 
     * @return string The delete query
     * */
    public function deleteQuery(): string;

    /**
     * A query built by the user
     * @return string
     */
    public function rawQuery(): string;
}
