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

$html = "";
$ico = "";
if (isset($_GET['ic'])) {
    if (is_numeric($_GET['ic'])) {
        $file = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi?typ_vyhledani=free&obchodni_firma=' . $_GET['ic'] . '&diakritika=false&ico=' . $_GET['ic'];
        if (!$xml = simplexml_load_file($file))
            echo('Chyba spojení s aplikací ARES MF ČR.');
        else {
            foreach ($xml->getDocNamespaces() as $strPrefix => $strNamespace) {
                if (strlen($strPrefix) == 0) {
                    $strPrefix = "are"; //Assign an arbitrary namespace prefix.
                }
                $xml->registerXPathNamespace($strPrefix, $strNamespace);
            }
            $html .= "Nalezených firem dle IČO: ";
            if (isset($xml->xpath("//are:Pocet_zaznamu")[0])) {
                $html .= $xml->xpath("//are:Pocet_zaznamu")[0];
                foreach ($xml->xpath("//are:ICO") as $key => $ico) {
                    if (isset($xml->xpath("//dtt:Cislo_orientacni")[$key]))
                        $orientacni = "/" . $xml->xpath("//dtt:Cislo_orientacni")[$key];
                    else
                        $orientacni = "";
                    $name = (string) $xml->xpath("//are:Obchodni_firma")[$key];
                    if (isset($xml->xpath("//dtt:Nazev_ulice")[$key]))
                        $ulice = (string) $xml->xpath("//dtt:Nazev_ulice")[$key];
                    else
                        $ulice = $xml->xpath("//dtt:Nazev_obce")[$key];
                    $adresa = $ulice . " " . $xml->xpath("//dtt:Cislo_domovni")[$key] . $orientacni . ", " . $xml->xpath("//dtt:PSC")[$key] . " " . $xml->xpath("//dtt:Nazev_obce")[$key];
                    if ($_GET['ic'] === (string)$ico) {
                        $icoCheck = " <i class=\"fa fa-check text-success\"></i>";
//                        $dicCheck = " <i class=\"fa fa-check text-success\"></i>";
                    } elseif (isset($_GET['ic'])) {
                        $icoCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">IČO v ADMIS: $_GET[ic]</span>";
//                        $dicCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">DIČ v ADMIS: CZ$_GET[ic]</span>";
                    } else {
                        $icoCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">IČO v ADMIS: <i>nevyplněno</i></span>";
//                        $dicCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">DIČ v ADMIS: <i>nevyplněno</i></span>";
                    }
                    if (isset($_GET['name']) && $_GET['name'] === $name)
                        $nameCheck = " <i class=\"fa fa-check text-success\"></i>";
                    elseif (isset($_GET['name']))
                        $nameCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Název v ADMIS: $_GET[name]</span>";
                    else
                        $nameCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Název v ADMIS: <i>nevyplněn</i></span>";
                    if (isset($_GET['adresa']) && $_GET['adresa'] == $adresa)
                        $addressCheck = " <i class=\"fa fa-check text-success\"></i>";
                    elseif (isset($_GET['adresa']))
                        $addressCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Adresa v ADMIS: $_GET[adresa]</span>";
                    else
                        $addressCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Adresa v ADMIS: <i>nevyplněna</i></span>";
                    if (($_GET['ic'] === (string)$ico)&&(isset($_GET['name']) && $_GET['name'] === $name)&&(isset($_GET['adresa']) && $_GET['adresa'] == $adresa)) {
                        $button = "<span class='text-success'><strong>V pořádku.</strong> Všechny údaje odpovídají údajům v ARES MF ČR.</span>";
                    } else {
                        $button = "<button class='btn btn-primary ml-auto vyplnit opravit' nazev='" . $name . "' adresa='" . $adresa . "' ico='" . $ico . "'>Opravit údaje</button>";
                    }

                    $html .= "
              <div class='card card-product card-raised'>
                <div class=\"card-header\">
                  <div class=\"row\">
                    <div class='col-12'>
                      <h6 class=\"card-title\">" . $name . $nameCheck . "</h6>
                    </div>
                  </div>
                </div>
                <div class=\"card-body\">
                  <div class='row text-left'>
                    <div class='col-12'>
                      Adresa: " . $adresa . $addressCheck . "
                    </div>
                  </div>
                  <div class='row text-left'>
                    <div class='col-12'>
                      IČO: " . $ico . $icoCheck . "
                    </div>
                  </div>
                </div>
                <div class=\"card-footer\">
                  $button
                </div>
              </div>
            ";
//                    <div class='row text-left'>
//                    <div class='col-12'>
//                    DIČ: CZ" . $ico . $dicCheck . "
//                    </div>
//                  </div>
                }
            } else {
                $html .= "0. <br> Firma s uvedeným IČO nebyla v ARES nalezena.<br><br>";
            }
        }
    }
}
if (isset($_GET['name'])) {
    include "cestina.php";
    $search=str_replace(" ","+", $_GET['name']);
    $searchX = strtr($search, $prevodni_tabulka);
        $file = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi?typ_vyhledani=free&obchodni_firma=' . $searchX . '&diakritika=false';
        if (!$xml = simplexml_load_file($file))
            echo('Chyba spojení s aplikací ARES MF ČR.');
        else {
            foreach ($xml->getDocNamespaces() as $strPrefix => $strNamespace) {
                if (strlen($strPrefix) == 0) {
                    $strPrefix = "are"; //Assign an arbitrary namespace prefix.
                }
                $xml->registerXPathNamespace($strPrefix, $strNamespace);
            }
            $html .= "Nalezených firem dle názvu: ";
            if (isset($xml->xpath("//are:Pocet_zaznamu")[0])) {
                $html .= $xml->xpath("//are:Pocet_zaznamu")[0];
                $htmlAfter = "";
                foreach ($xml->xpath("//are:ICO") as $key => $icoName) {
                    if ((string)$icoName != (string)$ico) {
                        if (isset($xml->xpath("//dtt:Cislo_orientacni")[$key]))
                            $orientacni = "/" . $xml->xpath("//dtt:Cislo_orientacni")[$key];
                        else
                            $orientacni = "";
                        if (isset($xml->xpath("//dtt:Nazev_ulice")[$key]))
                            $ulice = (string) $xml->xpath("//dtt:Nazev_ulice")[$key];
                        else
                            $ulice = $xml->xpath("//dtt:Nazev_obce")[$key];
                        $name = (string) $xml->xpath("//are:Obchodni_firma")[$key];
                        $adresa = $ulice . " " . $xml->xpath("//dtt:Cislo_domovni")[$key] . $orientacni . ", " . $xml->xpath("//dtt:PSC")[$key] . " " . $xml->xpath("//dtt:Nazev_obce")[$key];
                        if ($_GET['ic'] === (string)$icoName) {
                            $icoCheck = " <i class=\"fa fa-check text-success\"></i>";
//                            $dicCheck = " <i class=\"fa fa-check text-success\"></i>";
                        } elseif (isset($_GET['ic'])) {
                            $icoCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">IČO v ADMIS: $_GET[ic]</span>";
//                            $dicCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">DIČ v ADMIS: CZ$_GET[ic]</span>";
                        } else {
                            $icoCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">IČO v ADMIS: <i>nevyplněno</i></span>";
//                            $dicCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">DIČ v ADMIS: <i>nevyplněno</i></span>";
                        }
                        if (isset($_GET['name']) && $_GET['name'] === $name)
                            $nameCheck = " <i class=\"fa fa-check text-success\"></i>";
                        elseif (isset($_GET['name']))
                            $nameCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Název v ADMIS: $_GET[name]</span>";
                        else
                            $nameCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Název v ADMIS: <i>nevyplněn</i></span>";
                        if (isset($_GET['adresa']) && $_GET['adresa'] == $adresa)
                            $addressCheck = " <i class=\"fa fa-check text-success\"></i>";
                        elseif (isset($_GET['adresa']))
                            $addressCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Adresa v ADMIS: $_GET[adresa]</span>";
                        else
                            $addressCheck = " <i class=\"fa fa-times text-danger\"></i><br><span class=\"text-danger\">Adresa v ADMIS: <i>nevyplněna</i></span>";
                        if (($_GET['ic'] === (string)$icoName) && (isset($_GET['name']) && $_GET['name'] === $name) && (isset($_GET['adresa']) && $_GET['adresa'] == $adresa)) {
                            $button = "<span class='text-success'><strong>V pořádku.</strong> Všechny údaje odpovídají údajům v ARES MF ČR.</span>";
                        } else {
                            $button = "<button class='btn btn-primary ml-auto vyplnit opravit' nazev='" . $name . "' adresa='" . $adresa . "' ico='" . $icoName . "'>Opravit údaje</button>";
                        }

                        $htmlAfter .= "
              <div class='card card-product card-raised'>
                <div class=\"card-header\">
                  <div class=\"row\">
                    <div class='col-12'>
                      <h6 class=\"card-title\">" . $name . $nameCheck . "</h6>
                    </div>
                  </div>
                </div>
                <div class=\"card-body\">
                  <div class='row text-left'>
                    <div class='col-12'>
                      Adresa: " . $adresa . $addressCheck . "
                    </div>
                  </div>
                  <div class='row text-left'>
                    <div class='col-12'>
                      IČO: " . $icoName . $icoCheck . "
                    </div>
                  </div>
                </div>
                <div class=\"card-footer\">
                  $button
                </div>
              </div>
            ";
//                  <div class='row text-left'>
//                    <div class='col-12'>
//                        DIČ: CZ" . $icoName . $dicCheck . "
//                        </div>
//                  </div>
                    } else {
                        $html .= " <br><small class='text-muted'>(z toho jeden stejný jako záznam výše dle IČO)</small>";
                    }
                }
                $html .= $htmlAfter;
            } else {
                $html .= "0. <br> Firma s uvedeným názvem nebyla v ARES nalezena.";
            }
        }

}
echo $html;
