<?= $this->Html->css(
  ['contacts/index'],
  ['block' => true])
?>
<?= $this->Html->script(
  ['contacts/index'],
  ['block' => true])
?>
<?php $this->Html->scriptStart(['block' => true]) ?>
  var DEL_CFM_MSG = '<?= __d('contacts','Are you sure you want to delete the following contact?\n({0} {1} {2})', '%DATE%', '%TIME%', '%NAME%') ?>';
<?php $this->Html->scriptEnd(); ?>
<?php $this->Breadcrumbs->add([
  ['title' => __d('contacts', 'Contacts'), 'url' => null],
]); ?>
<h1><?= __d('contacts', 'Contacts') ?></h1>

<?= $this->Flash->render() ?>

<?php if (count($contacts) === 0) : ?>
  <div class="alert alert-secondary text-center">
     <?= __d('contacts', 'Not found') ?>
  </div>
<?php else : ?>
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th><?= __('Date') ?></th>
        <th><?= __d('contacts', 'Name') ?></th>
        <th><?= __d('contacts', 'Body') ?></th>
        <th><?= __('Action') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($contacts as $contact) : ?>
        <tr id="contact-<?= $contact->id ?>">
          <td class="td-date">
            <span class="date"><?= $contact->created->i18nFormat('yyyy.MM.dd') ?></span
              ><span class="time"><?= $contact->created->i18nFormat('HH:mm') ?></span>
          </td>
          <td class="td-name">
            <?= h($contact->name) ?>
          </td>
          <td class="td-body">
            <?= h($this->String->omit($contact->body, 40)) ?>
          </td>
          <td class="td-action">
            <?php $url = $this->Url->build(['action'=>'detail', $contact->id]); ?>
            <a href="<?= $url ?>" class="btn btn-sm btn-success"><?= __('View') ?></a>
            <a class="btn btn-sm btn-danger" data-class="btn-del" data-id="<?= $contact->id ?>"
              ><?= __('Delete') ?></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
