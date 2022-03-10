<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">group</i>
                </div>
                <div class="row">
                    <h4 class="card-title">Přehled uživatelů registrovaných v aplikaci ADMIS</h4>
                    <a href="newUser.php" class="btn btn-primary ml-auto mt-3"><i class="fa fa-plus"></i>Přidat nového uživatele</a>
                </div>

            </div>
            <div class="card-body">
                <?php echo getUsersOverviewTable(getUsersList()); ?>
            </div>
        </div>
    </div>
</div>