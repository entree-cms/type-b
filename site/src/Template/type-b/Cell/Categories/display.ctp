<section>
  <h1><?= __d('posts', 'Categories') ?></h1>
  <div class="content">
    <ul>
      <?php if (count($categories) > 0) : ?>
        <?php foreach ($categories as $category) : ?>
          <?php $url = $this->Url->build(['controller' => 'Blog', 'action' => 'category', $category->url_name]); ?>
          <li>
            <a href="<?= $url ?>">
              <?= h($category->name) ?>
              <span class="count">(<?= $countList[$category->id] ?>)</span></a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</section>
