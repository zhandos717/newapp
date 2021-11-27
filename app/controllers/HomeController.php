<?php
namespace App\controllers;
use App\lib\QueryBuilder;
use App\exceptions\NotEnoughMoneyException;
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
