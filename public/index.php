<?php 
    require '../vendor/autoload.php';
    use League\Plates\Engine;
    $templates = new Engine('../app/views/');



if ($_SERVER['REQUEST_URI'] == '/home') {
    
    echo $templates->render('homepage', ['name' => 'Jonathan']);
}


