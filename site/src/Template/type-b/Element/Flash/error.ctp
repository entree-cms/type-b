<?php
if (isset($params['escape']) && $params['escape'] === true) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
