<?php $this->Html->css(
  ['images/sub-list'],
  ['block' => true]
); ?>
<?php $this->Html->script(
  ['images/sub-list'],
  ['block' => true]
) ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
  var IMG_TPL   = `<?= $this->element('Images/image_list_item', ['imageId' => '%IMAGE_ID%', 'src' => '%SRC%']) ?>`;
  var LAST_PAGE = <?= $lastPage ?>;
  // Messages
  var DEL_CFM_MSG = "<?= __d('images', 'Are you sure you want to delete the image?') ?>";
  var DEL_ERR_MSG = "<?= __d('images', 'Image deletion failed.') ?>";
  var UP_ERR_MSG  = "<?= __d('images', 'Image upload failed.') ?>";
<?php $this->Html->scriptEnd(); ?>

<!-- Overlay box -->
<div id="overlay" class="overlay">
  <?= __d('images', 'You can upload by drag & drop.') ?>
</div>

<!-- File upload form -->
<div class="form-file">
  <div class="action">
    <input type="file" id="input-file">
    <button class="btn btn-primary" onclick="$('#input-file').click()"><?= __d('images', 'Choose file') ?></button>
  </div>
  <div class="message">
    <p><?= __('You can upload files by drag-and-drop') ?></p>
    <p class="max-size"><?= __('Maximum file size: about {0}', $maxFileSize) ?></p>
  </div>
</div>

<!-- Images -->
<div id="images" class="images">
  <?php foreach ($images as $image) : ?>
    <?= $this->element('Images/image_list_item', ['imageId' => $image->id, 'src' => $image->src]) ?>
  <?php endforeach; ?>
</div>

<?php $hidden = ($lastPage <= 1) ? ' style="display:none"' : ''; ?>
<div id="load-img" class="load-img"<?= $hidden ?>>
  <button id="btn-load" class="btn btn-primary"><?= __d('images', 'Load more images') ?></button>
</div>
