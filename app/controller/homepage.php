<?php

use App\QueryBuilder;

    if ($_SERVER['REQUEST_URI'] == '/home') {
        $c = new QueryBuilder();
        var_dump($c->getAll('posts'));
    }