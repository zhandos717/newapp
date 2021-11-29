<?php

namespace App\core;

use Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;
use PDO;
use Tamtamchik\SimpleFlash\Flash;


class Controller
{
    public $templates;
    public $auth;
    public $flash;
    public $model;
    public $queryFactory;
    public $pdo;
    
    public function __construct(Engine $engine, Auth $auth, Flash $flash, QueryFactory $queryFactory,PDO $pdo )
    {
        $this->templates = $engine;
        $this->auth = $auth;
        $this->flash = $flash;
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

};
