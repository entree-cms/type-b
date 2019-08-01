<?php $this->Html->css(
  ['post-categories/form'],
  ['block' => true]
) ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('post_categories', 'Categories'), 'url' => ['action' => 'index']],
  ['title' => __d('post_categories', 'Add New Category'), 'url' => null]
]); ?>
<h1><?= __d('post_categories', 'Add New Category') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">

  <!-- Form -->
  <?= $this->element('PostCategories/form'); ?>

  <!-- Submit button -->
  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button
      type="submit" class="btn btn-primary"
      onclick="return confirm('<?= __d('post_categories', 'Are you sure you want to add new category?') ?>')"
      ><?= __('Add New'); ?></button>
  </div>

</form>
