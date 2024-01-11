<?php

declare(strict_types=1);

namespace Cherry\Base;

use Cherry\BakeORM\DataRepository\DataRepository;
use Cherry\BakeORM\DataRepository\DataRepositoryFactory;
use Cherry\Base\Exception\BaseInvalidArgumentException;

/**
 * Class BaseModel
 * 
 * @package Cherry
 * @subpackage Base
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class BaseModel
{
    /**
     * Table name
     * 
     * @var string $tableName The name of the table
     */
    private string $tableName;

    /**
     * Table ID column
     * 
     * @var string $tableIDColumn The name of the ID column
     */
    private string $tableIDColumn;

    /**
     * Data repository
     * 
     * @var object $repository The data repository
     */
    private object $repository;

    /**
     * Constructor for the class.
     *
     * @param string $tableName The name of the table.
     * @param string $tableIDColumn The ID column of the table.
     * @throws BaseInvalidArgumentException Table name and table ID column are required.
     * @return void
     */
    public function __construct(string $tableName, string $tableIDColumn)
    {
        if (empty($tableName) || empty($tableIDColumn)) {
            throw new BaseInvalidArgumentException('Table name and table ID column are required');
        }

        $factory = new DataRepositoryFactory('', $tableName, $tableIDColumn);
        $this->repository = $factory->create(DataRepository::class);
    }

    /**
     * Retrieves the repository.
     *
     * @return mixed The repository.
     */
    public function getRepo(): mixed
    {
        return $this->repository;
    }
}