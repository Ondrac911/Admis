<?php
/**
 * Created by PhpStorm.
 * User: Petr Hnyk
 * Date: 04.02.2020
 * Time: 14:40
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

if (isset($_GET['data'])) {
    if (is_numeric($_GET['data'])) {
        $file = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi?typ_vyhledani=free&obchodni_firma='.$_GET['data'].'&diakritika=false&ico='.$_GET['data'];
    } else {
        include "cestina.php";
        $search=str_replace(" ","+", $_GET['data']);
        $searchX = strtr($search, $prevodni_tabulka);
        $file = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi?typ_vyhledani=free&obchodni_firma='.$searchX.'&diakritika=false';
    }
    if (!$xml = simplexml_load_file($file))
        echo('Chyba spojení s aplikací ARES MF ČR.');
    else {
        foreach($xml->getDocNamespaces() as $strPrefix => $strNamespace) {
            if(strlen($strPrefix)==0) {
                $strPrefix="are"; //Assign an arbitrary namespace prefix.
            }
            $xml->registerXPathNamespace($strPrefix,$strNamespace);
        }

        if (isset($xml->xpath("//are:Pocet_zaznamu")[0])) {
            if ((int)$xml->xpath("//are:Pocet_zaznamu")[0]===-1) {
                $html = "<span class='text-danger'>Upřesněte prosím zadání, nalezeno příliš velké množství výsledků.</span>";
            } else {
                $html = "Nalezených firem: ";
                $html .= $xml->xpath("//are:Pocet_zaznamu")[0];
                //print_r($xml->getName());
                //print_r($namespaces);

//        print_r($xml->children('are'));
                foreach ($xml->xpath("//are:ICO") as $key => $ico) {
                    if (isset($xml->xpath("//dtt:Cislo_orientacni")[$key]))
                        $orientacni = "/" . $xml->xpath("//dtt:Cislo_orientacni")[$key];
                    else
                        $orientacni = "";
                    if (isset($xml->xpath("//dtt:Nazev_ulice")[$key]))
                        $ulice = (string) $xml->xpath("//dtt:Nazev_ulice")[$key];
                    else
                        $ulice = $xml->xpath("//dtt:Nazev_obce")[$key];
                    if (isset($xml->xpath("//dtt:Text")[$key]) && (string)$xml->xpath("//dtt:Text")[$key]=="RŽP")
                        $dicInfo = " <small class='text-muted'>(neodpovídá u fyzických osob a právnických osob s VČP!)</small>";
                    else
                        $dicInfo = " <small class='text-muted'>(neodpovídá u fyzických osob a právnických osob s VČP!)</small>";
                    $html .= "
              <div class='card card-product card-raised'>
                <div class=\"card-header\">
                  <div class=\"row\">
                    <div class='col-12'>
                      <h6 class=\"card-title\">" . $xml->xpath("//are:Obchodni_firma")[$key] . "</h6>
                    </div>
                  </div>
                </div>
                <div class=\"card-body\">
                  <div class='row text-left'>
                    <div class='col-12'>
                      Adresa: " . $ulice . " " . $xml->xpath("//dtt:Cislo_domovni")[$key] . $orientacni . ", " . $xml->xpath("//dtt:PSC")[$key] . " " . $xml->xpath("//dtt:Nazev_obce")[$key] . "
                    </div>
                  </div>
                  <div class='row text-left'>
                    <div class='col-12'>
                      IČO: " . $ico . "
                    </div>
                  </div>
                  <div class='row text-left'>
                    <div class='col-12'>
                      DIČ: CZ" . $ico . $dicInfo . "
                    </div>
                  </div>
                </div>
                <div class=\"card-footer\">
                  <button class='btn btn-primary ml-auto vyplnit' nazev='" . $xml->xpath("//are:Obchodni_firma")[$key] . "' adresa='" . $ulice . " " . $xml->xpath("//dtt:Cislo_domovni")[$key] . $orientacni . ", " . $xml->xpath("//dtt:PSC")[$key] . " " . $xml->xpath("//dtt:Nazev_obce")[$key] . "' ico='" . $ico . "'>Vyplnit údaje</button>
                </div>
              </div>
            ";
                }
            }
        } else {
            $html = "Nalezených firem: 0. <br> Firma nebyla v ARES nalezena.";
        }
        echo $html;
    }
}