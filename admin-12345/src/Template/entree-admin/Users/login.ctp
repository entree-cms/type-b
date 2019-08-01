<?php $this->Html->css(
  ['users/login'],
  ['block' => true]
); ?>
<form method="post">
  <div class="card">
    <div class="card-body">
      <!-- Flash message -->
      <?= $this->Flash->render() ?>
      <!-- Username -->
      <div class="form-group">
        <label for="username"><?= __d('users', 'Username') ?></label>
        <input
          type="text" class="form-control" id="username" name="username"
          value="<?= h($this->request->getData('username')) ?>">
      </div>
      <!-- Password -->
      <div class="form-group">
        <label for="password"><?= __d('users', 'Password') ?></label>
        <input
          type="password" class="form-control" id="password" name="password"
          value="<?= h($this->request->getData('password')) ?>">
      </div>
      <div class="text-center">
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
        <button type="submit" class="btn btn-primary"><?= __d('users', 'Sign in') ?></button>
      </div>
    </div>
  </div>
</form>
