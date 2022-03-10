<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 04.07.2018
 * Time: 13:38
 */

require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);

$title = 'Hlášení problémů';
?>
<?php include PARTS . "startPage.inc"; ?>


        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">Jak na hlášení problémů
                        <small class="description">Vyberte podsekci</small>
                    </h4>
                </div>
                <div class="card-body ">
                    <ul class="nav nav-pills nav-pills-rose" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#obecne" role="tablist">
                                Obecně
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#helpdesk" role="tablist">
                                Portál helpdesk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pristupy" role="tablist">
                                Přístupy do helpdesku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kontakty" role="tablist">
                                Kontakty
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane active show" id="obecne">
                          <p> Je nám líto, že jste byli nuceni zavítat na tuto stránku, patrně něco nefunguje dle Vašich představ. Pokud to tak je tak máte několik možností jak nahlásit problém případně budeme rádi i za zpětnou vazbu týkající se vývoje nové funkcionality.<br>
                            Preferovaným způsobem pro hlášení problémů je portál helpdesk, zaprvné to ulehčuje práci nám a je to pomyslný "bič" na nás a také vy vidíte průběh řešení problémů. Postup hlášení prostřednictvím portálu helpdesk naleznete v sekci portál helpdesk
                            <br>Také se na nás můžete obrátit na některém z kontaktu, uvedených v kontaktech.</p>
                        </div>
                        <div class="tab-pane" id="helpdesk">
                          <p>  Helpdesk patří mezi preferované možnosti kontaktu, nebojte se hlásit naprosto vše a to i včetně námetů na vylepšení nebo naprogramování nové funkcionality. Také žádosti o složitější výstupy z databáze (reporty) můžete zadávat přes tento systém.<br>
                            Helpdesk naleznete na adrese <a href="https://helpdesk.cvut.cz">https://helpdesk.cvut.cz</a> přístupy Vám pak byly předány univerzálním uživatelem a naleznete je v samostatné záložce.</p>
                            Snažili jsme se Vám vše maximálně zjednodušit, nicméně i tak jsou věci, které je nutné k rychlému vyřízení Vašeho problémů vyplnit:<ul>
                                <li><strong>Projekt:</strong> zkontrolujte, že máte vybraný projekt FD_Správa sítě (měl by být předvolen)</li>
                                <li><strong>Typ úlohy:</strong> Vyberte typ úlohy, stačí rozlišovat zda se jedná o Chybu (Incident) nebo Požadavek na službu (Zlepšení)</li>
                                <li><strong>Komponenta:</strong> Vyberte komponentu ADMIS</li>
                                <li><strong>Souhrn:</strong> Nadpis požadavku, stačí krátky ale výstižný nadpis problému</li>
                                <li><strong>Popis:</strong> Detailněji popište charakter požadavku/problému + podpis a email na Vás</li>
                            </ul>
                            <p>Vypadá to sice složitě, ale opravdu není, uvidíte.</p>
                        </div>
                        <div class="tab-pane" id="pristupy">
                            <p>Do portálu helpdesk.cvut.cz Vám byly vytvořeny následující přihlašovací údaje:</p>
                            <ul>
                                <li><strong>Přihlašovací jméno: admisStr</strong></li>
                                <li><strong>Heslo: ksusDopravka18.</strong></li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="kontakty">
                            <p>Můžete nás také kontaktovat na následujících kontaktech:</p>
                           <ul>
                               <li><strong>Ondřej Doležal</strong> back-end programátor, provoz serveru a databáze, analytik požadavků. Email: <strong>ondra@it247.cz</strong>, mobil: <strong>606 825 307</strong></li>
                               <li><strong>Pham Son Tung (prostě Michal)</strong> programátor. Email: <strong>phamstm@gmail.com</strong>, tel: <strong>721 941 367</strong></li>
                               <li><strong>Karel Kocián</strong> projektový manažer. Email: <strong>kocian@fd.cvut.cz</strong>, tel: <strong>607 592 412</strong></li>
                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/nastaveni.js\"></script>
<script type=\"text/javascript\">Loader.load()</script>
";
?>

<?php include PARTS . "endPage.inc"; ?>

