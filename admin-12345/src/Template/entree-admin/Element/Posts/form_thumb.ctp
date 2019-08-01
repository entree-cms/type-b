<?php $hasThumb = (is_numeric(@$defaults['thumb_id'])) ?>
<div class="form-thumb form-group">
  <label for="btn-choose-thumb"><?= __d('posts', 'Thumbnail') ?></label>
  <!-- No image -->
  <?php $hidden = ($hasThumb) ? ' style="display: none"' : ''; ?>
  <div id="alert-no-thumb" class="alert alert-secondary"<?= $hidden ?>>
    <p class="text-center">
      <?= __d('Posts', 'No image') ?>
    </p>
  </div>
  <!-- Image / Alt text -->
  <?php $hidden = (!$hasThumb) ? ' style="display: none"' : ''; ?>
  <div id="thumb" class="thumb"<?= $hidden ?>>
    <img id="img-thumb" class="img-thumb" src="<?= $defaults['thumbSrc'] ?>">
    <input
      type="hidden" id="input-thumb-id" name="thumb_id"
      value="<?= h(@$defaults['thumb_id']) ?>">
    <input
      type="text" id="input-thumb-alt" class="form-control" name="thumb_alt"
      value="<?= h(@$defaults['thumb_alt']) ?>">
  </div>
  <!-- Buttons -->
  <div class="text-center">
    <button
      type="button" class="btn btn-success"
      data-class="btn-img-choose" data-mode="thumb"><?= __d('Posts', 'Choose image') ?></button>
    <button
      type="button" id="btn-remove-thumb" class="btn btn-danger"<?= $hidden ?>
      data-class="btn-img-remove" data-mode="thumb"><?= __('Remove') ?></button>
  </div>
</div>
