<?php
$title = "Můj profil";
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 20.06.2018
 * Time: 15:37
 */
require_once __DIR__ . "/../conf/config.inc";
require_once SYSTEMINCLUDES . "authenticateUser.php";
overUzivatele($pristup_zakazan);
$userInfo = getUserDetails($_SESSION['username']);
?>
<?php include PARTS."startPage.inc"; ?>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <a href="#pablo">
                                    <img
                                        src="data:image/png;base64,<?php print createAvatar(getInitialsFromName($_SESSION['jmeno'])) ?>"/>
                                </a>
                            </div>
                            <div class="card-body">
                                <h6 class="card-category text-gray"><?php echo $_SESSION['ou']; ?></h6>
                                <h4 class="card-title"><?php echo $_SESSION['jmeno']; ?></h4>
                                <p class="card-description">
                                    Uživatel <?php echo $_SESSION['jmeno']; ?> je v systému ADMIS uveden
                                    od <?php echo $userInfo[0] ?>, za dobu existence jeho účtu bylo
                                    vytvořeno <?php echo $userInfo[2] ?> projektů a u <?php echo $userInfo[3] ?> je
                                    uveden jako osoba odpovědná. V současné době je členem organizační jednotky
                                    <?php echo $_SESSION['ou']; ?>. Poslední aktualizace profilu (zahrnuje i změnu
                                    hesla) proběhla <?php echo $userInfo[1] ?>. Celkově pak, od založení účtu, bylo
                                    zaznamenáno <?php echo $userInfo[4] ?> pokusů o přihlášení z toho
                                    evidujeme <?php echo $userInfo[5] ?> jako úspěšných, poslední přihlášení bylo
                                    zaznamenáno v <?php echo $userInfo[6] ?>.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                    <i class="material-icons">perm_identity</i>
                                </div>
                                <h4 class="card-title">Editace profilu
                                    <small class="category">Zkontrolujte své údaje</small>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form id="editProfileForm" action="../submits/editProfileSubmit.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="bmd-label-floating">Jméno a přijmení</label>
                                                <input name="name" id="name" type="text" class="form-control"
                                                       value="<?php echo $_SESSION['jmeno'] ?>">
                                                <input name="username" type="hidden" value="<?php echo $_SESSION['username'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="bmd-label-floating">Email </label>
                                                <input name="email" id="email" type="email" value="<?php echo $_SESSION['email'] ?> " class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ou" class="bmd-label-floating"></label>

                                                <select name="idOu" class="selectpicker" data-style="select-with-transition"
                                                        data-live-search="true"
                                                        title="Vyberte organizační jednotku" tabindex="-98">
                                                        <?php echo selectOu(); ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="editProfileSubmit" class="btn btn-danger pull-right">Aktualizovat</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-warning">
                                <div class="card-icon">
                                    <i class="material-icons">settings</i>
                                </div>
                                <h4 class="card-title">Změna hesla
                                    <small class="category">Vyplňte pole níže</small>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form method="post" id="passwordChangeForm" action="../submits/changePasswordSubmit.php">
                                    <input name="username" type="hidden" value="<?php echo $_SESSION['username'] ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="oldPass" class="bmd-label-floating">Původní heslo</label>
                                                <input name="oldPass" id="oldPass" type="password" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="newPass" class="bmd-label-floating">Nové heslo</label>
                                                <input name="newPass" id="newPass" type="password" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="newPassVerify" class="bmd-label-floating">Nové heslo
                                                    znovu</label>
                                                <input name="newPassVerify" id="newPassVerify" type="password" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="changePasswordSubmit" class="btn btn-danger pull-right">Aktualizovat</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>


<?php
$customScripts = "";
$customScripts .= "
<script src=\"/js/profile.js\"></script>
";
?>


<?php include PARTS."endPage.inc"; ?>
