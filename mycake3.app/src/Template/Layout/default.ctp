<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('foundation.min.css') ?>
    <?= $this->Html->css('app.css') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('style.css') ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/js/script.js"></script>
    <script src="/js/geolocation.js"></script>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<nav class="top-bar expanded" data-topbar role="navigation">
    <ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href=""><?= $this->fetch('title') ?></a></h1>
        </li>
    </ul>
    <div class="top-bar-section">
        <ul class="right">
            <?php if ($authUser) : ?>
                <li><?= $this->Html->link(__('View Profile'), ['controller' => 'Users', 'action' => 'view', $authUser['id']]) ?></li>
                <li><?= $this->Html->link(__('Messages'), ['controller' => 'Messages', 'action' => 'inbox']) ?></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
            <?php else : ?>
                <li><?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?></li>
                <li><?= $this->Html->link(__('Create an account'), ['controller' => 'Users', 'action' => 'add']) ?></li>
            <?php endif; ?>
        </ul>

    </div>
</nav>
<?= $this->Flash->render() ?>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
<footer>

    <script src="/js/vendor/what-input.js"></script>
    <script src="/js/vendor/foundation.js"></script>
    <script src="/js/app.js"></script>

</footer>
</body>
</html>
