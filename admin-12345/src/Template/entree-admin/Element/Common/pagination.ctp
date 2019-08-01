<?php
$prev = $this->Paginator->prev('< ' . __('Prev'));
$nums = $this->Paginator->numbers(['first' => 1, 'modulus' => 1, 'last' => 1]);
$next = $this->Paginator->next(__('Next') . ' >');
?>
<?php if ($nums) : ?>
  <ul class="pagination">
    <?= $prev. $nums . $next ?>
  </ul>
<?php endif; ?>
