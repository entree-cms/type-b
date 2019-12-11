<!-- Name -->
<div class="form-group">
  <label class="required" for="input-name"><?= __d('post_categories', 'Name') ?></label>
  <?= $this->Alert->error(@$errors['name']) ?>
  <input
    type="text" name="name" id="input-name" class="form-control"
    value="<?= h(@$defaults['name']) ?>">
</div>

<!-- URL Name -->
<div class="form-group">
  <label class="required" for="input-url_name"><?= __d('post_categories', 'URL Name') ?></label>
  <?= $this->Alert->error(@$errors['url_name']) ?>
  <input
    type="text" name="url_name" id="input-url-name" class="form-control"
    value="<?= h(@$defaults['url_name']) ?>">
</div>

<!-- Parent category -->
<div class="form-group">
  <label for="select-parent-category"><?= __d('post_categories', 'Parent category') ?></label>
  <?= $this->Alert->error(@$errors['post_category_id']) ?>
  <select name="post_category_id" id="select-parent-category" class="form-control">
    <option value="">-</option>
    <?= $this->FormPlus->options(['options' => $postCategoryList, 'default' => @$defaults['post_category_id']]) ?>
  </select>
</div>

<!-- Description -->
<div class="form-group">
  <label for="input-description"><?= __d('post_categories', 'Description') ?></label>
  <?= $this->Alert->error(@$errors['description']) ?>
  <textarea name="description" id="input-description" class="form-control" cols="20" rows="7"
    ><?= h(@$defaults['description']) ?></textarea>
</div>
