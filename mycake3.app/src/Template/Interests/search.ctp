<?php foreach ($interests as $interest): ?>
    <p class="selectable" data-id="<?= h($interest->id) ?>"><?= h($interest->name) ?></p>
<?php endforeach; ?>
<p><?= $this->Html->link(__('Can\'t find your interest listed? add it here'), ['controller' => 'Interests', 'action' => 'add']) ?></p>
