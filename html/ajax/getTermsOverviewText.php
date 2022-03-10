<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$text = projectTermsInNextWeekNotificationText();
echo $text;
?>