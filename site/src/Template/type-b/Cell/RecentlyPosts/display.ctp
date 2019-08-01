<?php if (count($posts) > 0) : ?>
  <section class="recently">
    <h1><?= __d('posts', 'Recently posts') ?></h1>
    <div class="content">
      <ul>
        <?php foreach ($posts as $post) : ?>
          <li>
            <a href="<?= $post->url ?>">
              <span class="title"><?= h($post->title) ?></span>
              <span class="date"><?= $post->date->i18nFormat('YYYY.MM.dd') ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
<?php endif; ?>
