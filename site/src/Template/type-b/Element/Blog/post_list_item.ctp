<article class="list-item" onclick="location.href='<?= $post->url ?>'">
  <section class="body">
    <h1>
      <a href="<?= $post->url ?>"><?= h($post->title) ?></a>
    </h1>
    <ul class="meta">
      <li class="date">
        <?= $post->date->i18nFormat('YYYY.MM.dd') ?>
      </li>
      <li class="categories">
        <?= $post->categories ?>
      </li>
    </ul>

    <div>
      <?= h($post->abstract) ?>
    </div>
  </section>
  <section class="thumb">
    <?php if ($post->thumb === null) : ?>
      <div class="no-image">
        No image
      </div>
    <?php else: ?>
      <img src="<?= $post->thumb->src ?>">
    <?php endif; ?>
  </section>
</article>
