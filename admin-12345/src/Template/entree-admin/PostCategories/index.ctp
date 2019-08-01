<?php $this->Html->script(
  ['post-categories/index'],
  ['block' => true]
) ?>
<?php $this->Html->scriptStart(['block' => true]) ?>
  var DEL_CFM_MSG = '<?= __('Are you sure you want to delete "{0}"?', '%NAME%') ?>';
<?php $this->Html->scriptEnd(); ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('post_categories', 'Categories'), 'url' => null],
]); ?>
<h1><?= __d('post_categories', 'Categories') ?></h1>

<?= $this->Flash->render() ?>

<?php if (count($categories) === 0): ?>
  <div class="alert alert-secondary text-center">
    <?= __d('post_categories', 'Not found'); ?>
  </div>
<?php else: ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th><?= __d('post_categories', 'Category') ?></th>
        <th><?= __d('post_categories', 'Description') ?></th>
        <th><?= __('Action') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $category) : ?>
        <tr>
          <td>
            <?php for ($i = 1; $i < $category->level; $i++) : ?>&nbsp;-<?php endfor; ?>
            <span id="name-<?= h($category->id) ?>"><?= h($category->name) ?></span>
          </td>
          <td>
            <?php if ($category->description) : ?>
              <?= h($this->String->omit($category->description, 40)) ?>
            <?php else : ?>
              <div class="text-center text-muted">-</div>
            <?php endif; ?>
          </td>
          <td>
            <?php $url = $this->Url->build(['action' => 'edit', $category->id]); ?>
            <a href="<?= $url ?>" class="btn btn-sm btn-success"><?= __('Edit') ?></a>
            <a class="btn btn-sm btn-danger" data-class="btn-del" data-id="<?= h($category->id) ?>"
              ><?= __('Delete') ?></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<div class="text-center">
  <?php $url = $this->Url->build(['action' => 'add']) ?>
  <a href="<?= $url ?>" class="btn btn-success"><?= __d('post_categories', 'Add New Category') ?></a>
</div>
