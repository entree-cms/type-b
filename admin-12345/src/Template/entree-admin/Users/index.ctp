<?php $this->Html->script(
  ['users/index'],
  ['block' => true]
); ?>
<?php $this->Html->scriptStart(['block' => true]) ?>
  var DEL_CFM_MSG = '<?= __('Are you sure you want to delete "{0}"?', '%NAME%') ?>';
<?php $this->Html->scriptEnd(); ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('users', 'Users'), 'url' => null],
]); ?>
<h1><?= __d('users', 'Users') ?></h1>

<?= $this->Flash->render() ?>

<table class="table table-striped">
  <thead>
    <tr class="text-center">
      <th><?= __d('users', 'Username') ?></th>
      <th><?= __d('users', 'Name') ?></th>
      <th><?= __d('users', 'Nickname') ?></th>
      <th><?= __d('users', 'Email') ?></th>
      <th><?= __('Action') ?></th>
    </tr>
  </thead>
  <tbody class="text-center">
    <?php foreach ($users as $user) : ?>
      <tr>
        <!-- Username -->
        <td>
          <?= h($user->username) ?>
        </td>
        <!-- Name -->
        <td>
          <?php $name = $user->name; ?>
          <?php if ((string)$name !== '') : ?>
            <?= h($name) ?>
          <?php else : ?>
            <div class="text-muted">-</div>
          <?php endif; ?>
        </td>
        <!-- Nickname -->
        <td>
          <span id="name-<?= h($user->id) ?>"><?= h($user->nickname) ?></span>
        </td>
        <!-- Email -->
        <td>
          <?php if ((string)$user->email !== '') : ?>
            <?= h($user->email) ?>
          <?php else : ?>
            <div class="text-muted">-</div>
          <?php endif; ?>
        </td>
        <!-- Buttons -->
        <td class="text-left">
          <?php $url = $this->Url->build(['action' => 'edit', $user->id]) ?>
          <a href="<?= $url ?>" class="btn btn-sm btn-success"><?= __('Edit') ?></a>
          <?php if ($user->id !== $loginUser['id']) : ?>
            <a class="btn btn-sm btn-danger" data-class="btn-del" data-id="<?= h($user->id) ?>"
              ><?= __('Delete') ?></a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="text-center">
  <?php $url = $this->Url->build(['action' => 'add']) ?>
  <a href="<?= $url ?>" class="btn btn-success"><?= __d('users', 'Add New User') ?></a>
</div>
