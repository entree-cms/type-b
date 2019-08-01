<?php if (count($posts) === 0) : ?>
  <div class="alert alert-secondary text-center">
    <?= __d('posts', 'Not found') ?>
  </div>
<?php else: ?>
  <table class="table table-hover table-striped">
    <thead>
      <tr class="text-center">
        <th><?= __('Date') ?></th>
        <th><?= __d('posts', 'Title') ?></th>
        <th><?= __d('posts', 'URL Name') ?></th>
        <th><?= __d('post_categories', 'Categories') ?></th>
        <th><?= __d('posts', 'Writer') ?></th>
        <th><?= __d('posts', 'Status') ?></th>
        <th><?= __('Modified') ?></th>
        <th><?= __('Action') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($posts as $post) : ?>
        <tr class="text-center">
          <!-- Date -->
          <td>
            <span class="date"><?= $post->date->i18nFormat('yyyy.MM.dd') ?></span>
            <span class="time"><?= $post->date->i18nFormat('HH:mm') ?></span>
          </td>
          <!-- Title -->
          <td class="text-left">
            <span id="title-<?= h($post->id) ?>"><?= h($post->title) ?></span>
          </td>
          <!-- URL Name -->
          <td class="text-left">
            <?= h($post->url_name) ?>
          </td>
          <!-- Categories -->
          <td class="text-left">
            <?php
            $categories = $post->post_categories;
            if (count($categories) === 0) {
              echo '<div class="text-center text-muted">-</div>';
            } else {
              $names = [];
              foreach ($categories as $category) {
                $names[] = $category->name;
              }
              echo implode(', ', $names);
            }
            ?>
          </td>
          <!-- Writer -->
          <td class="text-left">
            <?= h($post->user->nickname) ?>
          </td>
          <!-- Status -->
          <td>
            <?= h(__d('post_statuses', $post->post_status->name)) ?>
          </td>
          <!-- Modified -->
          <td>
            <span class="date"><?= $post->modified->i18nFormat('yyyy.MM.dd') ?></span>
            <span class="time"><?= $post->modified->i18nFormat('HH:mm') ?></span>
          </td>
          <!-- Buttons -->
          <td>
            <!-- Edit -->
            <?php $url = $this->Url->build(['controller' => 'Posts', 'action' => 'edit', $post->id]) ?>
            <a href="<?= $url ?>" class="btn btn-sm btn-success"><?= __('Edit') ?></a>
            <?php if ($this->request->getParam('controller') === 'Posts') : ?>
              <!-- Delete -->
              <a class="btn btn-sm btn-danger" data-class="btn-del" data-id="<?= h($post->id) ?>"
                ><?= __('Delete') ?></a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
