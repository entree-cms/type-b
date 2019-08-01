<section>
  <h1><?= __d('posts', 'Archives') ?></h1>
  <div class="content">
    <ul>
      <?php if (count($monthList) > 0) : ?>
        <?php foreach ($monthList as $ym => $count) : ?>
          <?php
          $url = $this->Url->build(['controller' => 'Blog', 'action' => 'archive', $ym]);
          $year = substr($ym, 0, 4);
          $month = substr($ym, 4, 2);
          ?>
          <li>
            <a href="<?= $url ?>">
              <?= $year ?>.<?= $month ?>
              <span class="count">(<?= $count ?>)</span></a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
      <li>
        <a href="<?= $this->Url->build(['controller' => 'Blog', 'action' => 'index']) ?>"><?= __d('posts', 'All posts') ?></a>
      </li>
    </ul>
  </div>
</section>
