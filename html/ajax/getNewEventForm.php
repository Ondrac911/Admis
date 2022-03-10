<?php
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

$dbh = new DatabaseConnector();
$stmt = $dbh->getDbLink()->prepare('SELECT * FROM ou WHERE hidden = 0');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$options = "<option value=\"NULL\" class='text-heavyyellow'>Soukromá událost</option>";
foreach ($result as $ou) {
    $options .= "<option value=\"".$ou['idOu']."\" class='text-purple'>".$ou['name']."</option>";
}
$options .= "<option value=\"-1\" class='text-heavyblue'>Veřejná událost (bude se zobrazovat všem)</option>";
$form = "
   <div class=\"form-group\">
      <input class=\"form-control\" placeholder=\"Název události\" id=\"eventTitle\">
   </div>
   <div class=\"form-group\">
      <textarea class=\"form-control\" placeholder=\"Popis události\" id=\"eventDescription\"></textarea>
   </div>
   <div class=\"form-group\">
      <label class=\"form-group\" for=\"time\">Čas (nepovinné)</label>
      <input type=\"time\" id=\"time\" name=\"time\" class=\"form-control\">
   </div>
   <div class=\"form-group\">
   <label class=\"form-group\" for=\"ou\">Soukromá událost / událost pro organizační jednotku</label>
    <select class=\"custom-select\" id='ou'>
    ".$options."
    </select>
    </div>
";
echo $form;
?>