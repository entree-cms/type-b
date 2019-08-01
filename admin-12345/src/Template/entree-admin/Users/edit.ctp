<?php $this->Html->css(
  ['users/form'],
  ['block' => true]
) ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('users', 'Users'), 'url' => ['controller' => 'users' , 'action' => 'index']],
  ['title' => __d('users', 'Edit User'), 'url' => null]
]); ?>
<h1><?= __d('users', 'Edit User') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">

  <?= $this->element('Users/form') ?>

  <!-- Submit button -->
  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button type="submit" class="btn btn-primary" onclick="return confirm('<?= __('Are you sure you want to update?') ?>')"
      ><?= __('Save'); ?></button>
  </div>

</form>
