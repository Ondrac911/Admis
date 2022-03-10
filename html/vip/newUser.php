<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 02.01.2020
 * Time: 16:00
 */

require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);
$title = 'Nastavení';
$hashToken = generateHash(date('H'));
?>
<?php include PARTS."startPage.inc"; ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <h4 class="card-title">Nový uživatel</h4>
                    </div>
                    <div class="card-body">
                        <form method='post' action='/submits/newUserSubmit.php' id="newUser" name='newUser' class='form-horizontal'>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title">Identifikace</h4>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">person</i>
                                            </span>
                                        </div>
                                        <div class="form-group col">
                                            <label for="name" class="bmd-label-floating">Jméno</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">import_contacts</i>
                                        </span>
                                        </div>
                                        <div class="form-group col">
                                            <label for="username" class="bmd-label-floating">Uživatelské jméno</label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                    </div>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                        </div>
                                        <div class="form-group col">
                                            <label for="email" class="bmd-label-floating">e-mail</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Práva</h4>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">school</i>
                                            </span>
                                        </div>
                                        <div class="form-group col">
                                            <div class="dropdown bootstrap-select show-tick dropup">
                                                <select required class="selectpicker" data-style="select-with-transition"
                                                        name="idRoleType" title="Role" tabindex="-98">
                                                    <?php
                                                    print_r(selectRoleTypes())
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">group_add</i>
                                            </span>
                                        </div>
                                        <div class="form-group col">
                                            <div class="dropdown bootstrap-select show-tick dropup">
                                                <select required class="selectpicker" data-style="select-with-transition"
                                                        name="idOu" title="Organizační jednotka" tabindex="-98">
                                                    <?php
                                                    print_r(selectOu())
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="card-title">Přístup</h4>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        </div>
                                        <div class="form-group col">
                                            <label for="name" class="bmd-label-floating">Heslo</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="input-group form-control-lg">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        </div>
                                        <div class="form-group col">
                                            <label for="name" class="bmd-label-floating">Znovu heslo</label>
                                            <input type="password" class="form-control" name="passwordConfirm" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" form="newUser" class="btn btn-danger">Uložit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$customScripts = "<script src='/js/newUser.js'></script>";
$customScripts .= "";
?>

<?php include PARTS."endPage.inc"; ?>