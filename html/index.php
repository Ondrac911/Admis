<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 15.06.2018
 * Time: 9:32
*/
require_once __DIR__."/conf/config.inc";
session_start();

if(isset($_SESSION['username'])){
  session_destroy();
}
if(isset($_GET['errorUser']) && ($_GET['errorUser'] == "Špatné uživatelské jméno nebo heslo" OR $_GET['errorUser'] == "Chyba ověřování, zkontroluj username a heslo")) {
    $error = "<div class=\"alert alert-danger\" role=\"alert\">";
    $error .= urldecode($_GET['errorUser']);
    $error .= "</div>";
    }

?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="vip/dashboard/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="vip/dashboard/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Administrace staveb - přihlášení
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!--     Favicon     -->
    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">

    <!-- CSS Files -->
    <link href="vip/dashboard/assets/css/material-dashboard.css?v=2.0.2" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="vip/dashboard/assets/demo/demo.css" rel="stylesheet" />
</head>
<style type="text/css">
    .back-login{
        background-image: url('img/login.jpg');
        background-size: cover;
        background-position: top center;
    }

    .hiddenAlert{
        opacity: 0;
        -webkit-transform: translate3d(0, -60px, 0);
        -moz-transform: translate3d(0, -60px, 0);
        -o-transform: translate3d(0, -60px, 0);
        -ms-transform: translate3d(0, -60px, 0);
        transform: translate3d(0, -60px, 0);
    }
</style>

<body class="off-canvas-sidebar">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white" id="navigation-example">
    <div class="container">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="index.php"><img src="img/logoInvert.png" alt="logoAdmin" width="175"/> </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a href="about.php" class="nav-link">
                        <i class="material-icons">notes</i> O aplikaci
                    </a>
                </li>
                <li class="nav-item  active ">
                    <a href="index.php" class="nav-link">
                        <i class="material-icons">fingerprint</i> Přihlášení
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="wrapper wrapper-full-page index-login">
    <div class="page-header login-page header-filter back-login" filter-color="black" >
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="container">
            <div class="col-lg-4 col-md-6 col-sm-6 ml-auto mr-auto">

                <form class="form" method="post" action="submits/loginSubmit.php">
                    <div class="card card-login card-hidden">
                        <div class="card-header card-header-rose text-center">
                            <h3 class="card-title">Přihlášení</h3>
                            <div class="social-line">
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">face</i>
                                  </span>
                                </div>
                                <input type="text" name= 'username' required class="form-control" placeholder="Uživatelské jméno">
                              </div>
                            </span>
                            <span class="bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="material-icons">lock_outline</i>
                                  </span>
                                </div>
                                <input type="password" name= 'pass' required class="form-control" placeholder="Heslo">
                              </div>
                            </span>
                        </div>
                        <div class="card-footer justify-content-center">
                            <input type="submit" class="btn btn-rose btn-link btn-lg" value="Přihlásit">
                        </div>
                    </div>
                </form>

                <?php if (isset($_GET['errorUser']))
                    echo "<div id='errorAlert' class='alert alert-danger text-center hiddenAlert' role='alert'>
                            <strong>".$_GET['errorUser']."</strong>
                          </div>";
                ?>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <br class="copyright float-center">
                   Aplikace  ADMIS v2.0 vznikla ve spolupráci s ČVUT Fakultou dopravní a
                KSÚS Středočeského kraje</br>
                &copy; Ondřej Doležal, Pham Son Tung, Petr Hnyk

                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="vip/dashboard/assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="vip/dashboard/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="vip/dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="vip/dashboard/assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="vip/dashboard/assets/js/material-dashboard.min.js?v=2.0.2" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $().ready(function() {
            $sidebar = $('.sidebar');

            $sidebar_img_container = $sidebar.find('.sidebar-background');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                    $('.fixed-plugin .dropdown').addClass('open');
                }

            }

            $('.fixed-plugin a').click(function(event) {
                // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                if ($(this).hasClass('switch-trigger')) {
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                }
            });

            $('.fixed-plugin .active-color span').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-color', new_color);
                }

                if ($full_page.length != 0) {
                    $full_page.attr('filter-color', new_color);
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.attr('data-color', new_color);
                }
            });

            $('.fixed-plugin .background-color .badge').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('background-color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-background-color', new_color);
                }
            });

            $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');


                var new_image = $(this).find("img").attr('src');

                if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    $sidebar_img_container.fadeOut('fast', function() {
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $sidebar_img_container.fadeIn('fast');
                    });
                }

                if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $full_page_background.fadeOut('fast', function() {
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                        $full_page_background.fadeIn('fast');
                    });
                }

                if ($('.switch-sidebar-image input:checked').length == 0) {
                    var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }
            });

            $('.switch-sidebar-image input').change(function() {
                $full_page_background = $('.full-page-background');

                $input = $(this);

                if ($input.is(':checked')) {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar_img_container.fadeIn('fast');
                        $sidebar.attr('data-image', '#');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page_background.fadeIn('fast');
                        $full_page.attr('data-image', '#');
                    }

                    background_image = true;
                } else {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar.removeAttr('data-image');
                        $sidebar_img_container.fadeOut('fast');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page.removeAttr('data-image', '#');
                        $full_page_background.fadeOut('fast');
                    }

                    background_image = false;
                }
            });

            $('.switch-sidebar-mini input').change(function() {
                $body = $('body');

                $input = $(this);

                if (md.misc.sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    md.misc.sidebar_mini_active = false;


                } else {
                    setTimeout(function() {
                        $('body').addClass('sidebar-mini');

                        md.misc.sidebar_mini_active = true;
                    }, 300);
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                    clearInterval(simulateWindowResize);
                }, 1000);

            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.card').removeClass('card-hidden');
            $('#errorAlert').removeClass('hiddenAlert');
        }, 700);
    });
</script>
</body>

</html>