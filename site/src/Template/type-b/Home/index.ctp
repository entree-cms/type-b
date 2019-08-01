<?php $this->Html->css(
  ['index'],
  ['block' => true]
)?>
<?php if ($post): ?>
  <?= $this->element('Blog/post_detail'); ?>
<?php else: ?>
  <div class="alert alert-secondary text-center">
    公開中の投稿はありません
  </div>
<?php endif; ?>
