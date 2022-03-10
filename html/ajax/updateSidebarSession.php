<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if ($_POST['sidebarMini']==1)
    $_SESSION['sidebarMini']=1;
else
    $_SESSION['sidebarMini']=0;
