<?php $hasEyecatch = (is_numeric(@$defaults['eyecatch_id'])) ?>
<div class="form-eyecatch form-group">
  <label for="btn-choose-eyecatch"><?= __d('posts', 'Eyecatch') ?></label>
  <?php $hidden = ($hasEyecatch) ? ' style="display: none"' : ''; ?>
  <div id="alert-no-eyecatch" class="alert alert-secondary"<?= $hidden ?>>
    <p class="text-center">
      <?= __d('Posts', 'No image') ?>
    </p>
  </div>
  <?php $hidden = (!$hasEyecatch) ? ' style="display: none"' : ''; ?>
  <div id="eyecatch" class="eyecatch"<?= $hidden ?>>
    <img id="img-eyecatch" class="img-eyecatch" src="<?= $defaults['eyecatchSrc'] ?>">
    <input type="hidden" id="input-eyecatch-id" name="eyecatch_id" value="<?= h(@$defaults['eyecatch_id']) ?>">
    <input type="text" id="input-eyecatch-alt" class="form-control" name="eyecatch_alt" value="<?= h(@$defaults['eyecatch_alt']) ?>">
  </div>
  <div class="text-center">
    <button
      type="button" class="btn btn-success"
      data-class="btn-img-choose" data-mode="eyecatch"><?= __d('Posts', 'Choose image') ?></button>
    <button
      type="button" id="btn-remove-eyecatch" class="btn btn-danger"<?= $hidden ?>
      data-class="btn-img-remove" data-mode="eyecatch"><?= __('Remove') ?></button>
  </div>
</div>
