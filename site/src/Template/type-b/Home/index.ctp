<?php $this->Html->css(
  ['index'],
  ['block' => true]
)?>
<?php if ($post): ?>
  <?= $this->element('Blog/post_detail'); ?>
<?php else: ?>
  <div class="alert alert-secondary text-center">
    <?= __d('posts', 'Not posted yet') ?>
  </div>
<?php endif; ?>
