<?php
if(secCheckLevel() <= 90) {
    die();
}

    $error = [];
    $id = '1';
$collect = getFromDB("SELECT copyright, facebook, twitter, googlePlus, siteName, siteAdress, siteEmail, siteCity, siteZip, sitePhone
                      FROM sitesettings
                      WHERE id = :id", 1);
if(secCheckMethod('POST')) {

    $post = secGetInputArray(INPUT_POST);

    if(!secValidateToken($post['_once'], 600)) {
         $error['session'] = 'Din session er udløbet. Prøv igen.';
    }
    $facebook = validStringBetween($post['facebook'], 2, 65) ? $post['facebook'] : $error['facebook'] = 'Der er fejl i facebook linket.';
    $twitter = validStringBetween($post['twitter'], 2, 65) ? $post['twitter'] : $error['twitter'] = 'Der er fejl i twitter linket.';
    $googlePlus = validStringBetween($post['googlePlus'], 2, 65) ? $post['googlePlus'] : $error['googlePlus'] = 'Der er fejl i google Plus linket.';
    $siteName = validStringBetween($post['siteName'], 2, 45) ? $post['siteName'] : $error['siteName'] = 'Der er fejl i sidens navn.';
    $siteCity = validStringBetween($post['siteCity'], 2, 45) ? $post['siteCity'] : $error['siteCity'] = 'Der er fejl i byen-';
    $siteAdress = validStringBetween($post['siteAdress'], 2, 45) ? $post['siteAdress'] : $error['siteAdress'] = 'Der er fejl i adressen.';
    $siteEmail = validEmail($post['siteEmail']) ? $post['siteEmail'] : $error['siteEmail'] = 'Det er ikke en gyldig mail.';
    $siteZip = validIntBetween($post['siteZip'], 2, 10) ? $post['siteZip'] : $error['siteZip'] = 'Det er ikke en gyldig zip code.';
    $sitePhone = validTel($post['sitePhone']) ? $post['sitePhone'] : $error['sitePhone'] = 'Dette er ikke et gyldigt telefon nummer.';
    $copyright = validStringBetween($post['copyright'], 2, 45) ? $post['copyright'] : $error['copyright'] = 'Der er fejl i copyright.';
    if(sizeof($error) === 0) {
        echo 'success!';
        if(sqlQueryPrepared(
            "
                UPDATE 
                `sitesettings` 
                SET 
                `copyright`= :copyright, 
                `facebook`= :facebook,
                `twitter`= :twitter, 
                `googlePlus`= :googlePlus, 
                `siteName`= :siteName, 
                `siteCity`= :siteCity,
                `siteAdress`= :siteAdress, 
                `siteEmail`= :siteEmail, 
                `siteZip`= :siteZip, 
                `sitePhone`= :sitePhone
                WHERE id = :id
            ",
            array(
                ':copyright' => $copyright,
                ':facebook' => $facebook,
                ':twitter' => $twitter,
                ':googlePlus' => $googlePlus,
                ':siteName' => $siteName,
                ':siteCity' => $siteCity,
                ':siteAdress' => $siteAdress,
                ':siteEmail' => $siteEmail,
                ':siteZip' => $siteZip,
                ':sitePhone' => $sitePhone,
                ':id' => $id
            )
            )) {
                header('Location: ?p=dashboard&view=settings');
            } else {
                $error['SQL'] = 'Der skete en fejl ved opdatering af dataen i databasen.';
            }
    }
}
        //print_r($error);
//print_r($collect);
?>

<h1>Side Indstillinger</h1>
<div class="container">
    <div class="row">
        <form action="" method="post" class="col-md-12" enctype="multipart/form-data">
            <?=secCreateTokenInput()?>
                <div class="col s6">
                <div class="input-field col s12">
                <label for="facebook">Facebook</label>
                <input class="form-control" type="text" value="<?php echo $collect['facebook'] ?>" name="facebook"  id="facebook" min="2" max="65"><br />
                </div>

                <div class="input-field col s12">
                <label for="twitter">Twitter</label>
                <input class="form-control" type="text" value="<?php echo $collect['twitter'] ?>" name="twitter"  id="twitter" min="2" max="65"><br />
                </div>

                <div class="input-field col s12">
                <label for="googlePlus">Google Plus</label>
                <input class="form-control" type="text" value="<?php echo $collect['googlePlus'] ?>" name="googlePlus"  id="googlePlus" min="2" max="65"><br />
                </div>

                <div class="input-field col s12">
                <label for="siteName">Sidens Navn</label>
                <input class="form-control" type="text" value="<?php echo $collect['siteName'] ?>" name="siteName"  id="siteName" min="2" max="45"><br />
                </div>

                <div class="input-field col s12">
                <label for="siteCity">By</label>
                <input class="form-control" type="text" value="<?php echo $collect['siteCity'] ?>" name="siteCity"  id="siteCity" min="2" max="65"><br />
                </div>

                <div class="input-field col s12">
                <label for="siteAdress">Adresse</label>
                <input class="form-control" type="text" value="<?php echo $collect['siteAdress'] ?>" name="siteAdress"  id="siteAdress" min="2" max="45"><br />
                </div>

                <div class="input-field col s12">
                <label for="siteEmail">Email</label>
                <input class="form-control" type="text" value="<?php echo $collect['siteEmail'] ?>" name="siteEmail"  id="siteEmail" min="2" max="45"><br />
                </div>

                <div class="input-field col s12">
                <label for="siteZip">Zip Code</label>
                <input class="form-control" type="text" value="<?php echo $collect['siteZip'] ?>" name="siteZip"  id="siteZip" min="2" max="10"><br />
                </div>

                <div class="input-field col s12">
                <label for="sitePhone">Telefon</label>
                <input class="form-control" type="text" value="<?php echo $collect['sitePhone'] ?>" name="sitePhone"  id="sitePhone" min="2" max="20"><br />
                </div>

                <div class="input-field col s12">
                <label for="copyright">Copyright</label>
                <input class="form-control" type="text" value="<?php echo $collect['copyright'] ?>" name="copyright"  id="copyright" min="2" max="25"><br />
                </div>

                </div>
                <button type="submit" class="btn btn-default col-md-3" name="opretBruger">Gem ændringer</button>
                </div>
        </form>
    </div>
</div>