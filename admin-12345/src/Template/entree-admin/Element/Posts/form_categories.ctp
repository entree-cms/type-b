<div class="form-category form-group">
  <label for="checkbox-post-category"><?= __d('post_categories', 'Categories') ?></label>
  <div id="checkbox-post-category">
    <?php foreach ($postCategories as $category) : ?>
      <?php $margin = 7 * ($category->level - 1); ?>
      <?php $checked = (in_array($category->id, $defaults['post_categories']['_ids'])) ? ' checked ="checked"' : ''; ?>
      <label style="margin-left: <?= $margin ?>px">
        <input type="checkbox" name="post_categories[_ids][]" value="<?= $category->id ?>"<?= $checked ?>>
        <?= h($category->name) ?>
      </label>
    <?php endforeach; ?>
  </div>
</div>
