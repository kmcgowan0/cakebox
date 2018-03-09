<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messaged
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $message_threads
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="messages index large-9 medium-8 columns content">
    <h3><?= __('Messages') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('sender') ?></th>
            <th scope="col"><?= $this->Paginator->sort('body') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sent') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($message_threads as $message_thread): ?>
            <tr>
                <td><?php if ($message_thread->last()->sender == $authUser['id']) : ?>
                        Sent to <?php echo $message_thread->last()->recipient; ?>
                    <?php elseif ($message_thread->last()->recipient == $authUser['id']) : ?>
                        Received from <?php echo $message_thread->last()->sender; ?>
                    <?php endif; ?></td>
                <td><?= h($message_thread->last()->body) ?></td>
                <td><?= h($message_thread->last()->sent) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $message_thread->last()->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $message_thread->last()->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $message_thread->last()->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message_thread->last()->id)]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
