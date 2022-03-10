<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">history</i>
                </div>
                <h4 class="card-title">Přehled všech změn na projektech v posledních 180 dnech</h4>
            </div>
            <div class="card-body">
                <?php echo createHistoryTable(getArrActionsLogAllByInterval(180)); //když měnis interval zupdatuj zahlavi tabulky ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">history</i>
                </div>
                <h4 class="card-title">Přehled přihlašování uživatelů (posledních 1000) </h4>
            </div>
            <div class="card-body">
                <?php echo getLoginLogsTable(getLastLogins(1000)); ?>
            </div>
        </div>
    </div>
</div>