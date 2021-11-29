<?php
namespace App\controllers;
use App\lib\QueryBuilder;
use App\exceptions\NotEnoughMoneyException;
use League\Plates\Engine;
class HomeController{
    public $templates;
    public $QueryBuilder;

    public function __construct(Engine $engine, QueryBuilder $QueryBuilder)
    {
        $this->templates = $engine;
        $this->QueryBuilder = $QueryBuilder;
    }
    public function login(){

        echo  $this->templates->render('login');

    }
    public function index(){
        echo  $this->templates->render('homepage');
    }
    public function about($vars)
    {   
        try{

            $this->withdraw(15);
        }catch(NotEnoughMoneyException $exception){
            \flash()->error($exception->getMessage());
        }
        echo  $this->templates->render('aboutpage', $vars);
    }
    public function withdraw($anount = 1)
    {
        $total = 10;
        if($anount > $total){
            throw new NotEnoughMoneyException('Не достаточно средств');
        }
    }
};
