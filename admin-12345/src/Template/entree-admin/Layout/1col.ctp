<!DOCTYPE html>
<html lang="ja">
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $pageTitle ?></title>
  <?= $this->fetch('meta') ?>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->css([
    'common/style-1col',
  ]) ?>
  <?= $this->fetch('css') ?>
  <?= $this->Html->script([
    'common/jquery',
  ]) ?>
  <?= $this->fetch('script') ?>
  <script>
    var CSRF_TOKEN = '<?= $this->request->getParam('_csrfToken') ?>';
    var SITE_ROOT = '<?= $this->Url->build('/') ?>';
  </script>
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1><a href="<?= $this->Url->build('/') ?>"><?= __($siteInfo['title']) ?></a></h1>
    </div>
  </header>

  <div class="main">
    <main>
      <?= $this->fetch('content') ?>
    </main>
  </div>

  <footer>
    <div class="text-center">
      <small><?= __($siteInfo['title']) ?></small>
    </div>
  </footer>
</body>
</html>
