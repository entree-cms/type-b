<div class="form-date form-group">
  <label class="required" for="input-date"><?= __d('posts', 'Date') ?></label>
  <?= $this->Alert->error(@$errors['date']) ?>
  <div class="form-group-date">
    <?php $disabled = (@$defaults['date_now'] === '1') ? ' disabled' : ''; ?>
    <input
      type="text" name="date[0]" id="input-date" class="input-date form-control"
      value="<?= h(@$defaults['date'][0]) ?>"<?= $disabled ?>
    ><input
      type="text" name="date[1]" id="input-time" class="input-time form-control"
      value="<?= h(@$defaults['date'][1]) ?>"<?= $disabled ?>>
  </div>
  <div>
    <label>
      <?php $checked = (@$defaults['date_now'] === '1') ? ' checked' : ''; ?>
      <input type="checkbox" name="date_now" value="1" id="checkbox-date-now"<?= $checked ?>>
      <?= __d('posts', 'Now') ?>
    </label>
  </div>
</div>
