<div class="form-container">

  <div class="form-main">
    <!-- Title -->
    <div class="form-group">
      <label class="required" for="input-title"><?= __d('posts', 'Title') ?></label>
      <?= $this->Alert->error(@$errors['title']) ?>
      <input
        type="text" name="title" id="input-title" class="form-control"
        value="<?= h(@$defaults['title']) ?>">
    </div>

    <!-- URL Name -->
    <div class="form-group">
      <label class="required" for="input-permalink"><?= __d('posts', 'URL Name') ?></label>
      <?= $this->Alert->error(@$errors['url_name']) ?>
      <input
        type="text" name="url_name" id="input-url-name" class="form-control"
        value="<?= h(@$defaults['url_name']) ?>">
    </div>

    <!-- Body -->
    <div class="form-group">
      <label class="required" for="textarea-body"><?= __d('posts', 'Body') ?></label>
      <?= $this->Alert->error(@$errors['body']) ?>
      <textarea name="body" id="textarea-body" class="form-control" cols="20" rows="15"
        ><?= h(@$defaults['body']) ?></textarea>
    </div>

    <!-- Abstract -->
    <div class="form-group">
      <label for="input-abstract"><?= __d('posts', 'Abstract') ?></label>
      <?= $this->Alert->error(@$errors['abstract']) ?>
      <textarea name="abstract" id="input-abstract" class="form-control" cols="20" rows="3"
        ><?= h(@$defaults['abstract']) ?></textarea>
    </div>
  </div>

  <!-- Right side -->
  <div class="form-side">
    <!-- Date -->
    <?= $this->element('Posts/form_date'); ?>

    <!-- Status -->
    <div class="form-group">
      <label for="select-post-status"><?= __d('posts', 'Status') ?></label>
      <?= $this->Alert->error(@$errors['post_status_id']) ?>
      <select class="form-control" name="post_status_id" id="select-post-status">
        <?= $this->FormPlus->options(['options' => $postStatusList, 'default' => @$defaults['post_status_id']]) ?>
      </select>
    </div>

    <!-- Categories -->
    <?= $this->element('Posts/form_categories') ?>

    <!-- Eyecatch Image -->
    <?= $this->element('Posts/form_eyecatch') ?>

    <!-- Thumbnail Image -->
    <?= $this->element('Posts/form_thumb') ?>
  </div>
</div>
