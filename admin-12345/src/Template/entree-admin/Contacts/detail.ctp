<?= $this->Html->css(
  ['contacts/detail'],
  ['block' => true])
?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('contacts', 'Contacts'), 'url' => null],
  ['title' => $contact->created->i18nFormat('YYYY.MM.DD') . ' ' . h($contact->name), 'url' => null],
]); ?>
<h1><?= __d('contacts', 'Contact detail') ?></h1>

<?= $this->Flash->render() ?>

<form method="post">
  <table class="table table-bordered">
    <tr>
      <th><?= __d('contacts', 'Date') ?></th>
      <td><?= $contact->created->i18nFormat('YYYY.MM.DD HH:mm') ?></td>
    </tr>
    <tr>
      <th><?= __d('contacts', 'Name') ?></th>
      <td><?= h($contact->name) ?></td>
    </tr>
    <tr>
      <th><?= __d('contacts', 'Email') ?></th>
      <td><?= h($contact->email) ?></td>
    </tr>
    <tr>
      <th><?= __d('contacts', 'Body') ?></th>
      <td><?= nl2br(h($contact->body)) ?></td>
    </tr>
    <tr>
      <th><?= __d('contacts', 'Note') ?></th>
      <td class="td-padding-sm">
        <?= $this->Alert->error(@$errors['note']) ?>
        <textarea name="note"><?= @$defaults['note'] ?></textarea>
      </td>
    </tr>
  </table>

  <div class="text-center">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
    <button type="submit" class="btn btn-primary">
      <?= __('Save') ?>
    </button>
  </div>
</form>
