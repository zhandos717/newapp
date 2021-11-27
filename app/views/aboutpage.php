<?php $this->layout('layout', ['title' => 'О нас']) ?>



<?= flash()->display(); ?>

<h1>О нас </h1>
<p>Hello, <?= $this->e($name) ?></p>