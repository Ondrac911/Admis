<!DOCTYPE html>
<html lang="cs">
<head>
    <!-- Header -->
    <?php include PARTS."header.inc"; ?>

</head>

<body <?php if(isset($_SESSION['sidebarMini'])&&$_SESSION['sidebarMini']==1) echo "class='sidebar-mini'"; ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="wrapper">


    <div class="sidebar" data-color="rose" data-background-color="black" data-image="../img/road.jpg">
        <!-- Sidebar -->
        <?php include PARTS."sidebar.inc"; ?>
    </div>

    <div class="main-panel">
        <!-- Navbar -->
        <?php include PARTS."navbar.inc"; ?>
        <!-- End Navbar -->

        <div class="content">
            <div class="container-fluid">

                <?php
                if($testingBranch){
                    echo "<div class=\"alert alert-warning alert-with-icon\" data-notify=\"container\" style='margin-top: -5px;'>
                    <i class=\"material-icons\" data-notify=\"icon\">notifications</i>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                      <i class=\"material-icons\">close</i>
                    </button>
                    <span data-notify=\"message\"><strong>PRACUJETE VE VÝVOJOVÉ A TESTOVACÍ VERZI</strong></span>
                 
                  </div>";
                }
                if($developerMode){

                    echo "<div class=\"alert alert-danger alert-with-icon\" data-notify=\"container\" style='margin-top: -5px;'>
                    <i class=\"material-icons\" data-notify=\"icon\">notifications</i>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                      <i class=\"material-icons\">close</i>
                    </button>
                    <span data-notify=\"message\"><strong>Probíhají vývojářské práce na této verzi, nehlašte prosím problémy pokud je toto oznámení aktivní. Omluvte tak možné chyby aplikace, data vložena v tomto režimu mohou být ztracena!</strong></span>
                  </div>";

                }
                elseif($testingMode){

                    echo "<div class=\"alert alert-info alert-with-icon\" data-notify=\"container\" style='margin-top: -5px;'>
                    <i class=\"material-icons\" data-notify=\"icon\">notifications</i>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                      <i class=\"material-icons\">close</i>
                    </button>
                    <span data-notify=\"message\"><strong>V současné době probíhá testovací režim aplikace, hlašte prosím problémy pomocí portálu helpdesk, jak na to naleznete v sekci <a href='helpdesk.php'>'Hlášení problémů'</a></strong></span>
                  </div>";

                }
                ?>
