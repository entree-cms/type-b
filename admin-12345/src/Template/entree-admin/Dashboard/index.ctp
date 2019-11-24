<?php $this->Breadcrumbs->add([
  ['title' => __('Dashboard'), 'url' => null],
]); ?>
<h1><?= __('Dashboard') ?></h1>
<h2><?= __d('posts', 'Latest posts') ?></h2>
<!-- List table -->
<?= $this->element('Posts/list_table', ['posts' => $latestPosts]); ?>
