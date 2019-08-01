<?php
$this->Html->css(
  [
    'common/jquery-ui',
    'common/jquery-ui.theme',
    'posts/form'
  ],
  ['block' => true]
);
$this->Html->script(
  [
    'lib/jquery-ui/jquery-ui.min',
    'lib/tinymce/tinymce.min',
    'posts/form'
  ],
  ['block' => true]
);
$this->Breadcrumbs->add([
  ['title' => __d('posts', 'Posts'), 'url' => ['controller' => 'Posts', 'action' => 'index']],
  ['title' => __d('posts', 'Add New Post'), 'url' => false]
]);
?>
<h1><?= __d('posts', 'Add New Post') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">

  <!-- Form -->
  <?= $this->element('Posts/form'); ?>

  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button type="submit" class="btn btn-primary" onclick="return confirm('<?= __d('posts', 'Are you sure you want to add new post?') ?>')"
      ><?= __('Add New'); ?></button>
  </div>

</form>
