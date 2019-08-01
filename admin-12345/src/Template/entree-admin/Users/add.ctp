<?php $this->Html->css(
  ['users/form'],
  ['block' => true]
) ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('users', 'Users'), 'url' => ['controller' => 'users' , 'action' => 'index']],
  ['title' => __d('users', 'Add New User'), 'url' => null]
]); ?>
<h1><?= __d('users', 'Add New User') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">

  <?= $this->element('Users/form') ?>

  <!-- Submit button -->
  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button type="submit" class="btn btn-primary" onclick="return confirm('<?= __d('users', 'Are you sure you want to add new user?') ?>')"
      ><?= __('Add New'); ?></button>
  </div>

</form>
