<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 * @var \App\Model\Entity\Message $messages_in_thread
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <?php foreach ($messages_in_thread as $message_in_thread) : ?>
        <?php if ($message_in_thread->sender == $authUser['id']) {
            $send_class = 'sent';
        } else {
            $send_class = 'received';

        } ?>
        <div class="<?php echo $send_class; ?> user-message">
            <?= h($message_in_thread->body) ?>
            <p class="timestamp"><?= h($message_in_thread->sent) ?></p>
        </div>
    <?php endforeach; ?>
    <div class="large-12">
        <?= $this->Form->create($message) ?>
        <fieldset>
            <?php
            echo $this->Form->input('body', ['type' => 'textarea']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Send')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
