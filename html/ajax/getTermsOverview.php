<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
if ($_GET['moje']==1)
    $_SESSION['jenMojeProjekty']=1;
else
    $_SESSION['jenMojeProjekty']=0;
$table = "
<thead>
     <tr>
                        <th scope=\"col\">Termín</th>
                        <th scope=\"col\">Projekt</th>
                        <th scope=\"col\">ID</th>
                        <th scope=\"col\">Typ termínu</th>
                        <th scope=\"col\"></th>
     </tr>
</thead>
";
$table .= showTermsInNextWeek();
echo $table;
?>