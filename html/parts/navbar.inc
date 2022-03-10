<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                    <i class="material-icons text_align-center visible-on-sidebar-regular" data-toggle='tooltip' data-placement='right' data-original-title='Zmenšit menu'>more_vert</i>
                    <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini" data-toggle='tooltip' data-placement='right' data-original-title='Zvětšit menu'>view_list</i>
                </button>
            </div>
            <span class="navbar-brand"><?php echo $title;?></span>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#termsInNextWeekModal">
                        <i class="material-icons" id="nextWeekNotification" data-toggle='tooltip' data-placement='bottom' data-original-title='<?php projectTermsInNextWeekNotificationText(); ?>'>event</i>
                        <?php projectTermsInNextWeekNotification(); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#notificationsModal" onclick="notifySession();">
                        <i class="material-icons" data-toggle='tooltip' data-placement='bottom' data-original-title='<?php projectChangesNotificationText(); ?>'>notifications</i>
                        <?php projectChangesNotification(); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/index.php" >
                        <i class="material-icons" data-toggle='tooltip' data-placement='bottom' data-original-title='Odhlásit se'>power_settings_new</i>

                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

