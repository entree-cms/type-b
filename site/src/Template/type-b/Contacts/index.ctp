<?php
$this->Html->css(
  ['contacts/index'],
  ['block' => true]
)
?>
<section>
  <h1><?= __d('contacts', 'Contact') ?></h1>

  <?= $this->Flash->render() ?>

  <?php if ($this->request->getQuery('m') === 'c'): ?>
    <div class="alert alert-success">
      <p class="text-center">
        <?= __d('contacts', 'Your message has been sent') ?>
      </p>
      <p class="text-center">
        <a href="<?= $this->url->build('/') ?>"><?= __('Return to home') ?></a>
      </p>
    </div>
  <?php else: ?>
    <form method="post">
      <div class="dl-group">
        <dl>
          <dt class="required"><?= __d('contacts', 'Name') ?></dt>
          <dd>
            <?= $this->Alert->error(@$errors['name']) ?>
            <input type="text" name="name" value="<?= h(@$defaults['name']) ?>">
          </dd>
        </dl>
        <dl>
          <dt class="required"><?= __d('contacts', 'E-mail') ?></dt>
          <dd>
            <?= $this->Alert->error(@$errors['email']) ?>
            <input type="text" name="email" value="<?= h(@$defaults['email']) ?>">
          </dd>
        </dl>
        <dl>
          <dt class="required"><?= __d('contacts', 'Body') ?></dt>
          <dd>
            <?= $this->Alert->error(@$errors['body']) ?>
            <textarea name="body" cols="50" rows="10"><?= h(@$defaults['body']) ?></textarea>
          </dd>
        </dl>
      </div>

      <div class="action">
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
        <button type="submit" onclick="return confirm('<?= __d('contacts', 'Are you sure you want to send message?') ?>')">
          <?= __('Submit') ?>
        </button>
      </div>
    </form>
  <?php endif; ?>
</section>
