<?php

namespace App\core;

use Delight\Auth\Auth;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class Model
{
    public $templates;
    public $auth;
    public $flash;

    public function __construct(Engine $engine, Auth $auth, Flash $flash)
    {
        $this->templates = $engine;
        $this->auth = $auth;
        $this->flash = $flash;
    }
};
