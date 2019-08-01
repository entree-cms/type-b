<?php
if (isset($params['escape']) && $params['escape'] === true) {
  $message = h($message);
}
?>
<div class="alert alert-danger" onclick="this.classList.add('hidden');"><?= $message ?></div>
