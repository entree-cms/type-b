<?php $this->Html->css(
  ['blog/category'],
  ['block' => true]
) ?>
<?php $pagination = $this->element('Common/pagination'); ?>
<?php if (count($posts) === 0) : ?>
  <div class="alert alert-secondary">
    <?= __d('posts', 'Not found') ?>
  </div>
<?php else: ?>

  <?= $pagination ?>

  <?php foreach ($posts as $post) : ?>
    <?= $this->element('Blog/post_list_item', ['post' => $post]); ?>
  <?php endforeach; ?>

  <?= $pagination ?>

<?php endif; ?>
