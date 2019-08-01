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
    'common/font-awesome/css/all.min',
    'common/style',
  ]) ?>
  <?= $this->fetch('css') ?>
  <?= $this->Html->script([
    'lib/jquery/jquery.min',
  ]) ?>
  <?= $this->fetch('script') ?>
  <script>
    var CSRF_TOKEN = '<?= $this->request->getParam('_csrfToken') ?>';
    var SITE_ROOT = '<?= $this->Url->build('/') ?>';

    // Subwindow
    var subwin;
  </script>
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1><a href="<?= $this->Url->build('/') ?>"><?= __($siteInfo['title']) ?></a></h1>
      <nav>
        <div class="user">
          <i class="fas fa-user"></i>
          <?= $loginUser['nickname'] ?>
        </div>
        <!-- View site -->
        <div class="link">
          <a href="<?= $siteUrl ?>/" target="_blank">
            <i class="fas fa-home"></i>
            <?= __('View site') ?>
          </a>
        </div>
        <!-- Logout -->
        <div class="link">
          <?php $url = $this->Url->build(['controller' => 'users', 'action' => 'logout']); ?>
          <?php $msg = __d('users', 'Are you sure you want to logout?'); ?>
          <a href="<?= $url ?>" onclick="return confirm('<?= $msg ?>')">
            <i class="fas fa-door-open"></i>
            <?= __d('users', 'Logout') ?>
          </a>
        </div>
      </nav>
    </div>
  </header>

  <div class="main-sidebar">
    <div class="main">
      <?php $breadcrumbs = $this->Breadcrumbs->render(); ?>
      <?php if ($breadcrumbs) : ?>
        <nav aria-label="breadcrumb">
          <?= $breadcrumbs ?>
        </nav>
      <?php endif; ?>

      <main>
        <?= $this->fetch('content') ?>
      </main>

      <footer>
        <div class="text-center">
          <small><?= __($siteInfo['title']) ?></small>
        </div>
      </footer>
    </div>

    <aside id="sidebar" class="sidebar">
      <ul>
        <li>
          <?php $url = $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span><?= __('Dashboard') ?></span>
          </a>
        </li>
        <li class="separated">
          <?php $url = $this->Url->build(['controller' => 'Posts', 'action' => 'add']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-pencil-alt"></i>
            <span><?= __d('posts', 'Add New') ?></span>
          </a>
        </li>
        <li>
          <?php $url = $this->Url->build(['controller' => 'Posts', 'action' => 'index']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-list-ul"></i>
            <span><?= __d('posts', 'All Posts') ?></span>
          </a>
        </li>
        <li>
          <?php $url = $this->Url->build(['controller' => 'PostCategories', 'action' => 'index']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-tags"></i>
            <span><?= __d('post_categories', 'Categories') ?></span>
          </a>
        </li>
        <li class="separated">
          <?php $url = $this->Url->build(['controller' => 'Contacts', 'action' => 'index']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-envelope"></i>
            <span><?= __d('contacts', 'Contacts') ?></span>
          </a>
        </li>
        <li>
          <?php $url = $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>
          <a href="<?= $url ?>">
            <i class="fas fa-user"></i>
            <span><?= __d('users', 'Users') ?></span>
          </a>
        </li>
      </ul>
    </aside>
  </div>
</body>
</html>
