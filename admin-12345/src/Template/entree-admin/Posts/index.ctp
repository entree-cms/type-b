<?php $this->Html->script(
  ['posts/index'],
  ['block' => true]
); ?>
<?php $this->Html->scriptStart(['block' => true]) ?>
  var DEL_CFM_MSG = '<?= __('Are you sure you want to delete "{0}"?', '%NAME%') ?>';
<?php $this->Html->scriptEnd(); ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('posts', 'Posts'), 'url' => null],
]); ?>
<?php $pagination = $this->element('Common/pagination'); ?>
<h1><?= __d('posts', 'Posts') ?></h1>

<?= $this->Flash->render() ?>

<?= $pagination ?>

<?= $this->element('Posts/list_table'); ?>

<?= $pagination ?>

<div class="text-center">
  <?php $url = $this->Url->build(['action' => 'add']) ?>
  <a href="<?= $url ?>" class="btn btn-success"><?= __d('posts', 'Add New Post') ?></a>
</div>
