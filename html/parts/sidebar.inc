<!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->

<div class="logo">
    <a href="home.php" class="simple-text logo-mini">
        <img src="/img/mostAdmisWhiteMini.png" alt="logo admis - white mini" class="img-fluid"/>
    </a>

    <a href="home.php" class="simple-text logo-normal">
        <img src="/img/textAdmisWhiteMini.png" alt="text admis - white mini" class="img-fluid"/>
    </a>
</div>

<div class="sidebar-wrapper">
    <div class="user">
        <div class="photo">
            <img alt="sidebar bacground" src="data:image/png;base64,<?php print createAvatar(getInitialsFromName($_SESSION['jmeno'])) ?>"/>
        </div>
        <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                       <?php echo $_SESSION['jmeno']; ?>
                        <b class="caret"></b>
                    </span>
            </a>
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <span class="sidebar-mini"> MP </span>
                            <span class="sidebar-normal"> Můj profil </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vip/collaborators.php">
                            <span class="sidebar-mini"> <i class="material-icons">people</i> </span>
                            <span class="sidebar-normal"> Spolupracovníci </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "home") echo "active"; ?>">
            <a class="nav-link" href="home.php">
                <i class="material-icons">dashboard</i>
                <p> Dashboard </p>
            </a>
        </li>
        <li class="nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "newProject") echo "active"; ?>">
            <a class="nav-link" href="newProject.php">
                <i class="material-icons">library_add</i>
                <p> Nový projekt</p>
            </a>
        </li>
        <li class="nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "vypis") echo "active"; ?>">
            <a class="nav-link" href="vypis.php">
                <i class="material-icons">grid_on</i>
                <p> Výpis</p>
            </a>
        </li>
        <li class="nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "detail") echo "active"; ?>">
            <a class="nav-link"
               href="detail.php<?php if (isset($_GET["idProject"])) echo "?idProject=$_GET[idProject]"; ?>">
                <i class="material-icons">
                    details
                </i>
                <p> Detail </p>
            </a>
        </li>
        <li class="nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "mapa") echo "active"; ?>">
            <a class="nav-link" href="mapa.php">
                <i class="material-icons">map</i>
                <p> mapa </p>
            </a>
        </li>
        <li class="mt-5 nav-item <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "helpdesk") echo "active"; ?>">
            <a class="nav-link" href="helpdesk.php">
                <i class="material-icons">mood_bad</i>
                <p> Hlášení problémů </p>
            </a>
        </li>
        <?php
        $activeFirmy = '';
        $activeUzivatele = '';
        $activeLogy = '';
        $activeSoubory = '';
        $settShow = '';
        $activeButt = '';
        if ($_SESSION['role'] == 'adminEditor' OR $_SESSION['role'] == 'editor') {//sekce pro adminy
            if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == "nastaveni") {
                $activeButt = "active";
                $settShow = 'show';
                if (isset($_GET['sprava'])) {
                    switch ($_GET['sprava']) {
                        case "firmy":
                            $activeFirmy = 'active';
                            break;
                        case "uzivatele":
                            $activeUzivatele = 'active';
                            break;
                        case "logy":
                            $activeLogy = 'active';
                            break;
                        case "soubory":
                            $activeSoubory = 'active';
                            break;
                    }
                }
            }
            $html = "
        <li class='nav-item $activeButt'>
         <a class=\"nav-link\" data-toggle=\"collapse\" href=\"#nastaveni\" aria-expanded=\"true\">
                <i class=\"material-icons\">settings</i>
                <p> Globální Nastavení
                    <b class=\"caret\"></b>
                </p>
            </a>           <div class=\"collapse $settShow\" id=\"nastaveni\" style=\"\">
                <ul class=\"nav\">
                    <li class=\"nav-item $activeFirmy\" >
                        <a class=\"nav-link\" href='nastaveni.php?sprava=firmy' >
                            <span class=\"sidebar-mini\"> SF </span>
                            <span class=\"sidebar-normal\"> Správa firem </span>
                        </a>
                    </li>";
            if ($_SESSION['role'] == 'adminEditor')
                $html .=
                    "<li class=\"nav-item $activeUzivatele\" >
                        <a class=\"nav-link\" href=\"nastaveni.php?sprava=uzivatele\" >
                            <span class=\"sidebar-mini\"> SU </span>
                            <span class=\"sidebar-normal\"> Správa uživatelů </span>
                        </a>
                    </li>
                    <li class=\"nav-item $activeLogy\" >
                        <a class=\"nav-link\" href=\"nastaveni.php?sprava=logy\" >
                            <span class=\"sidebar-mini\"> PU </span>
                            <span class=\"sidebar-normal\"> Přehled událostí </span>
                        </a>
                    </li>
                    <li class=\"nav-item $activeSoubory\" >
                        <a class=\"nav-link\" href=\"nastaveni.php?sprava=soubory\" >
                            <span class=\"sidebar-mini\"> SS </span>
                            <span class=\"sidebar-normal\"> Správa souborů </span>
                        </a>
                    </li>";

            $html .= "        
                </ul>
            </div>
          
        </li>
            ";
            echo $html;
        }

        ?>


        <!--
<li class="nav-item ">
<a class="nav-link" data-toggle="collapse" href="#pagesExamples">
    <i class="material-icons">image</i>
    <p> Pages
        <b class="caret"></b>
    </p>
</a>

<div class="collapse" id="pagesExamples">
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="./pages/pricing.html">
                <span class="sidebar-mini"> P </span>
                <span class="sidebar-normal"> Pricing </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/rtl.html">
                <span class="sidebar-mini"> RS </span>
                <span class="sidebar-normal"> RTL Support </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/timeline.html">
                <span class="sidebar-mini"> T </span>
                <span class="sidebar-normal"> Timeline </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/login.html">
                <span class="sidebar-mini"> LP </span>
                <span class="sidebar-normal"> Login Page </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/register.html">
                <span class="sidebar-mini"> RP </span>
                <span class="sidebar-normal"> Register Page </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/lock.html">
                <span class="sidebar-mini"> LSP </span>
                <span class="sidebar-normal"> Lock Screen Page </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./pages/user.html">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal"> User Profile </span>
            </a>
        </li>
    </ul>
</div>
</li>

<li class="nav-item ">
<a class="nav-link" data-toggle="collapse" href="#componentsExamples">
    <i class="material-icons">apps</i>
    <p> Components
        <b class="caret"></b>
    </p>
</a>

<div class="collapse" id="componentsExamples">
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="./components/buttons.html">
                <span class="sidebar-mini"> B </span>
                <span class="sidebar-normal"> Buttons </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/grid.html">
                <span class="sidebar-mini"> GS </span>
                <span class="sidebar-normal"> Grid System </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/panels.html">
                <span class="sidebar-mini"> P </span>
                <span class="sidebar-normal"> Panels </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/sweet-alert.html">
                <span class="sidebar-mini"> SA </span>
                <span class="sidebar-normal"> Sweet Alert </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/notifications.html">
                <span class="sidebar-mini"> N </span>
                <span class="sidebar-normal"> Notifications </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/icons.html">
                <span class="sidebar-mini"> I </span>
                <span class="sidebar-normal"> Icons </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./components/typography.html">
                <span class="sidebar-mini"> T </span>
                <span class="sidebar-normal"> Typography </span>
            </a>
        </li>
    </ul>
</div>
</li>

<li class="nav-item ">
<a class="nav-link" data-toggle="collapse" href="#formsExamples">
    <i class="material-icons">content_paste</i>
    <p> Forms
        <b class="caret"></b>
    </p>
</a>

<div class="collapse" id="formsExamples">
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="./forms/regular.html">
                <span class="sidebar-mini"> RF </span>
                <span class="sidebar-normal"> Regular Forms </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./forms/extended.html">
                <span class="sidebar-mini"> EF </span>
                <span class="sidebar-normal"> Extended Forms </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./forms/validation.html">
                <span class="sidebar-mini"> VF </span>
                <span class="sidebar-normal"> Validation Forms </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./forms/wizard.html">
                <span class="sidebar-mini"> W </span>
                <span class="sidebar-normal"> Wizard </span>
            </a>
        </li>
    </ul>
</div>
</li>

<li class="nav-item ">
<a class="nav-link" data-toggle="collapse" href="#tablesExamples">
    <i class="material-icons">grid_on</i>
    <p> Tables
        <b class="caret"></b>
    </p>
</a>

<div class="collapse" id="tablesExamples">
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="./tables/regular.html">
                <span class="sidebar-mini"> RT </span>
                <span class="sidebar-normal"> Regular Tables </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./tables/extended.html">
                <span class="sidebar-mini"> ET </span>
                <span class="sidebar-normal"> Extended Tables </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./tables/datatables.net.html">
                <span class="sidebar-mini"> DT </span>
                <span class="sidebar-normal"> DataTables.net </span>
            </a>
        </li>
    </ul>
</div>
</li>

<li class="nav-item ">
<a class="nav-link" data-toggle="collapse" href="#mapsExamples">
    <i class="material-icons">place</i>
    <p> Maps
        <b class="caret"></b>
    </p>
</a>

<div class="collapse" id="mapsExamples">
    <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="./maps/google.html">
                <span class="sidebar-mini"> GM </span>
                <span class="sidebar-normal"> Google Maps </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./maps/fullscreen.html">
                <span class="sidebar-mini"> FSM </span>
                <span class="sidebar-normal"> Full Screen Map </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="./maps/vector.html">
                <span class="sidebar-mini"> VM </span>
                <span class="sidebar-normal"> Vector Map </span>
            </a>
        </li>
    </ul>
</div>
</li>

<li class="nav-item ">
<a class="nav-link" href="./widgets.html">
    <i class="material-icons">widgets</i>
    <p> Widgets </p>
</a>
</li>

<li class="nav-item ">
<a class="nav-link" href="./charts.html">
    <i class="material-icons">timeline</i>
    <p> Charts </p>
</a>
</li>

<li class="nav-item ">
<a class="nav-link" href="./calendar.html">
    <i class="material-icons">date_range</i>
    <p> Calendar </p>
</a>
</li>
-->
    </ul>
</div>