<?php
use Faker\Factory;

class Main{
    public function insert()
    {
        for ($i = 1; $i <= 30; $i++) {

            $this->query->insert('posts', [
                'title' => Factory::create()->name($gender = null | 'male' | 'female'),
                'text' => Factory::create()->realText($maxNbChars = 100, $indexSize = 2),
                'image' => Factory::create()->imageUrl(300, 300, 'cats')
            ]);
        }
    }
    
}