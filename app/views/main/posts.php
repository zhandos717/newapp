<?php $this->layout('layout/default', ['title' => 'Главная страница']) ?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Posts</h5>
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
                        <img src="https://picsum.photos/100" alt="">
                    </li>
                <?php endforeach ?>
            </ul>
            <nav aria-label="Page navigation example">
                <?= $paginator ?>
            </nav>
        </div>
    </div>
</div>