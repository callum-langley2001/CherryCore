<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

interface EntityManagerInterface
{
    public function getCrud(): object;
}
