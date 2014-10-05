<?php
use yii\helpers\Html;

$this->title = 'Registration finished';
?>
<h1>Registration finished.</h1>
<p>Check you email.</p>

<br><br><br><br><br><br>
<p>Email message:</p>
<p>Follow this link to finish registration: <a href="<?= $confirmUrl; ?>"><?= $confirmUrl; ?></a></p>