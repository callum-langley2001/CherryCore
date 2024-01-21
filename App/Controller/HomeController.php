<?php

declare(strict_types=1);

namespace App\Controller;

use Cherry\Base\BaseController;

class HomeController extends BaseController
{
    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
    }

    public function index()
    {
        echo 'hello';
    }
}
