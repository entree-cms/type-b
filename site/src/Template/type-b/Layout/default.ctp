<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $pageTitle ?></title>
  <?php if (is_string($pageDescription) && $pageDescription !== "") : ?>
    <meta name="description" content="<?= h($pageDescription) ?>">
  <?php endif; ?>
  <?= $this->fetch('meta') ?>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->css([
    'common/style'
  ]) ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1 class="title"><?= h($siteInfo['title']) ?></h1>
    </div>
    <nav class="nav">
      <ul>
        <?php $url = $this->Url->build('/'); ?>
        <li><a href="<?= $url ?>">HOME</a></li>
        <?php $url = $this->Url->build(['controller' => 'Blog', 'action' => 'index']); ?>
        <li><a href="<?= $url ?>"><?= __d('posts', 'Posts') ?></a></li>
        <?php $url = $this->Url->build(['controller' => 'contacts', 'action' => 'index']); ?>
        <li><a href="<?= $url ?>"><?= __d('contacts', 'Contact') ?></a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <main class="main">
      <?= $this->fetch('content') ?>
    </main>
    <aside class="sidebar">
      <?= $this->cell('LatestPosts') ?>

      <?= $this->cell('Categories') ?>

      <?= $this->cell('Archives') ?>
    </aside>
  </div>

  <footer>
    <small><?= h($siteInfo['title']) ?></small>
  </footer>
</body>
</html>
