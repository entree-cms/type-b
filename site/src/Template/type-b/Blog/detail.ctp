<?php $this->Html->css(
  ['blog/detail'],
  ['block' => true]
) ?>
<?= $this->element('Blog/post_detail'); ?>

<?php if ($prevPost) : ?>
  <div class="prev-post">
    <?php $url = $this->Url->build([$prevPost->url_name]); ?>
    <a href="<?= $url ?>"><?= h($prevPost->title) ?></a>
  </div>
<?php endif; ?>
<?php if ($nextPost) : ?>
  <div class="next-post">
    <?php $url = $this->Url->build([$nextPost->url_name]); ?>
    <a href="<?= $url ?>"><?= h($nextPost->title) ?></a>
  </div>
<?php endif; ?>
