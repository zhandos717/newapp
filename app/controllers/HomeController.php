<?php
namespace App\controllers;
use App\lib\QueryBuilder;
use League\Plates\Engine;
class HomeController{
    public $templates;
    public function __construct()
    {
        $this->templates = new Engine('../app/views/');
    }
    public function index($vars){
        echo  $this->templates->render('homepage', $vars);
    }
    public function about($vars)
    {
        echo  $this->templates->render('aboutpage', $vars);
    }
};
