<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $pageTitle ?></title>
  <?= $this->fetch('meta') ?>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->css([
    'common/font-awesome/css/all.min',
    'common/style-sub',
  ]) ?>
  <?= $this->fetch('css') ?>
  <?= $this->Html->script([
    'lib/jquery/jquery.min'
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

  <main>
    <?= $this->fetch('content') ?>
  </main>

</body>
</html>
