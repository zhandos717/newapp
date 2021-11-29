<?php $this->layout('layout/default', ['title' => 'Главная страница']) ?>




<ul>
    <?php
    foreach ($posts as $post) : ?>
        <li>
            <a href="/profile/<?= $this->e($post['id']) ?>">
                <?= $this->e($post['title']) ?>
            </a>
            <p> 
                <?= $this->e($post['content']) ?>
            </p>
        </li>
    <?php endforeach ?>
</ul>

<?= $paginator ?>