<article class="post">
  <header>
    <h1><?= h($post->title) ?></h1>
    <ul class="meta">
      <li class="date">
        <?= $post->date->i18nFormat('yyyy年M月d日') ?>
      </li>
      <li class="categories">
        <?= $post->categories ?>
      </li>
    </ul>
  </header>

  <?php if ($post->eyecatch): ?>
    <section class="eyecatch">
      <img src="<?= $post->eyecatch->src ?>">
    </section>
  <?php endif; ?>

  <section class="body">
    <?= strip_tags($post->body, ALLOWABLE_TAGS) ?>
  </section>
</article>
