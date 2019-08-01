<?php $this->Html->css(
  ['post-categories/form'],
  ['block' => true]
) ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('post_categories', 'Categories'), 'url' => ['action' => 'index']],
  ['title' => __d('post_categories', 'Edit Category'), 'url' => null]
]); ?>
<h1><?= __d('post_categories', 'Edit Category') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">

  <!-- Form -->
  <?= $this->element('PostCategories/form'); ?>

  <!-- Submit button -->
  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button type="submit" class="btn btn-primary" onclick="return confirm('<?= __('Are you sure you want to update?') ?>')"
      ><?= __('Save'); ?></button>
  </div>

</form>
