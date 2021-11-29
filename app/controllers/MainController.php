<?php
namespace App\controllers;
use App\core\Controller;
use JasonGrimes\Paginator;

class MainController extends Controller{
    public function login(){
        echo  $this->templates->render('authorization/login');
    }
    public function registration()
    {
        echo  $this->templates->render('authorization/register');
    }
    public function index()
    {   
        if($this->auth->isLoggedIn()){

            // $faker = Factory::create();

            // $this->queryBuilder->insert([
            //     'title'=> $faker->words('4',\true),
            //     'content' => $faker->realText(20),
            // ],'posts');
    
        
            $totalItems = 63;
            $itemsPerPage = 3;
            $currentPage = 1;
            $urlPattern = '/posts/(:num)';

            $paginator  = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $select = $this->queryFactory->newSelect();
            $posts = $select->cols(['*'])->from('posts')->setPaging(3)->page(1);
            // prepare the statement
            $sth = $this->pdo->prepare($select->getStatement());

            // bind the values and execute
            $sth->execute($select->getBindValues());

            // get the results back as an associative array
            $posts = $sth->fetchAll($this->pdo::FETCH_ASSOC);


            $vars = [
                'paginator' => $paginator,
                'posts' => $posts,
            ];
            echo  $this->templates->render('main/home', $vars);
        }else
        \header('Location: /login');
    }

    public function posts($vars)
    {
        if ($this->auth->isLoggedIn()) {

            $totalItems = 63;
            $itemsPerPage = 3;
            $currentPage = $vars['id'];
            $urlPattern = '/posts/(:num)';

            $paginator  = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $select = $this->queryFactory->newSelect();
            $posts = $select->cols(['*'])->from('posts')->setPaging(3)->page($currentPage);
            // prepare the statement
            $sth = $this->pdo->prepare($select->getStatement());

            // bind the values and execute
            $sth->execute($select->getBindValues());

            // get the results back as an associative array
            $posts = $sth->fetchAll($this->pdo::FETCH_ASSOC);

            $vars = [
                'paginator' => $paginator,
                'posts' => $posts,
            ];
            echo  $this->templates->render('main/posts', $vars);
        } else
            \header('Location: /login');
    }
    public function users()
    {   
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])->from('users')->where('id=:id')->bindValue('id', $this->auth->getUserId());
        $sth = $this->pdo->prepare($select->getStatement());
        // bind the values and execute
        $sth->execute($select->getBindValues());
        // get the results back as an associative array
        $vars = $sth->fetch($this->pdo::FETCH_ASSOC);
        echo  $this->templates->render('main/users',$vars);
    }
    public function about($vars)
    {   
        echo  $this->templates->render('aboutpage', $vars);
    }
    public function error()
    {
        echo  $this->templates->render('error/error');
    }
};
