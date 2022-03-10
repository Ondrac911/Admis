</div>
    <footer class="footer">
        <?php include PARTS."footer.inc"; ?>
    </footer>
</div>


    <div class="modal fade" id="notificationsModal" tabindex="-1" role="dialog" aria-hidden="true" data-dismiss="modal">
        <div class="modal-dialog hugeModal modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Přehled nových změn v projektech</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-secondary" id="hideAll">Označit všechny jako přečtené</button>
                    <br>
                    <table class="table table-striped" id="notificationsModalTable">
                        <thead>
                        <tr>
                            <th scope="col">Datum a čas</th>
                            <th scope="col">Projekt</th>
                            <th scope="col">Událost</th>
                            <th scope="col">Operace</th>
                        </tr>
                        </thead>
                    <?php showProjectChanges(); ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="termsInNextWeekModal" tabindex="-1" role="dialog" aria-hidden="true" data-dismiss="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="termsModalTitle"><?php if ((isset($_SESSION['jenMojeProjekty']))&&($_SESSION['jenMojeProjekty']==1))
                        echo "Přehled termínů <b>u mých projektů</b> v příštích 30 dnech (<a id=\"switchModalTitle\" href=\"#\">zobrazit všechny stavby</a>)";
                        else  echo "Přehled termínů <b>u všech projektů</b> v příštích 30 dnech (<a id=\"switchModalTitle\" href=\"#\">zobrazit jen moje stavby</a>)"; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="termsModalTable">
                        <thead>
                        <tr>
                            <th scope="col">Termín</th>
                            <th scope="col">Projekt</th>
                            <th scope="col">ID</th>
                            <th scope="col">Typ termínu</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <?php echo showTermsInNextWeek(); ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-hidden="true" data-dismiss="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="pacman">
                        <div class="pacman-top"></div>
                        <div class="pacman-bottom"></div>
                        <div class="feed"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <?php include PARTS."scripts.inc"; ?>

    <?php if(isset($_SESSION['sidebarMini'])&&$_SESSION['sidebarMini']==1)
        echo "
        <script type=\"text/javascript\">
        md.misc.sidebar_mini_active = true;
        </script>
        ";
    ?>

    <script src="/js/notifications.js"></script>
    <script>
        function notifySession() {
            $.get("/submits/notifySubmit.php", function(data, status){
                //  alert("Data: " + data + "\nStatus: " + status);
            });
        }

    </script>

    <?php
    echo $customScripts;
    ?>

</body>





</html>