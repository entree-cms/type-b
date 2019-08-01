<?php $isEdit = ($this->request->action === 'edit'); ?>

<!-- Username -->
<div class="form-group">
  <label for="input-username" class="required"><?= __d('users', 'Username') ?></label>
  <?= $this->Alert->error(@$errors['username']) ?>
  <input
    type="text" name="username" id="input-username" class="form-control"
    value="<?= h(@$defaults['username']) ?>">
</div>

<!-- Password -->
<?php $required = (!$isEdit) ? ' class="required"' : ''; ?>
<div class="form-group">
  <label for="input-password"<?= $required ?>><?= __d('users', 'Password') ?></label>
  <?php if ($isEdit) : ?>
    <div class="alert alert-sm alert-warning">
       <?= __('Please enter only if you want to change.') ?>
    </div>
  <?php endif ?>
  <?= $this->Alert->error(@$errors['password']) ?>
  <input
    type="password" name="password" id="input-password" class="form-control"
    value="<?= h(@$defaults['password']) ?>">
</div>

<!-- Nickname -->
<div class="form-group">
  <label for="input-nickname" class="required"><?= __d('users', 'Nickname') ?></label>
  <?= $this->Alert->error(@$errors['nickname']) ?>
  <input
    type="text" name="nickname" id="input-nickname" class="form-control"
    value="<?= h(@$defaults['nickname']) ?>">
</div>

<!-- Last name -->
<div class="form-last-name form-group">
  <label for="input-last-name"><?= __d('users', 'Last name') ?></label>
  <?= $this->Alert->error(@$errors['last_name']) ?>
  <input
    type="text" name="last_name" id="input-last-name" class="form-control"
    value="<?= h(@$defaults['last_name']) ?>">
</div>

<!-- First name -->
<div class="form-first-name form-group">
  <label for="input-first-name"><?= __d('users', 'First name') ?></label>
  <?= $this->Alert->error(@$errors['first_name']) ?>
  <input
    type="text" name="first_name" id="input-first-name" class="form-control"
    value="<?= h(@$defaults['first_name']) ?>">
</div>

<!-- E-mail -->
<div class="form-group">
  <label for="input-email"><?= __d('users', 'Email') ?></label>
  <?= $this->Alert->error(@$errors['email']) ?>
  <input
    type="text" name="email" id="input-email" class="form-control"
    value="<?= h(@$defaults['email']) ?>">
</div>
