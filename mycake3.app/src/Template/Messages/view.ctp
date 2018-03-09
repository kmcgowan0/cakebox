<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Body') ?></th>
            <td><?= h($message->body) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender') ?></th>
            <td><?= $this->Number->format($message->sender) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Recipient') ?></th>
            <td><?= $this->Number->format($message->recipient) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sent') ?></th>
            <td><?= h($message->sent) ?></td>
        </tr>
    </table>
</div>
