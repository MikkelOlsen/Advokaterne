
<?php
//print_r('Time: ' . (time() - $_SESSION['TokenAge']));

if(secCheckLevel() <= 90) {
    echo '<h4>Du har desværre ikke rettigheder til at redigere brugere.</h4>';
    die();
} else {
    $collect = getFromDB("SELECT users.navn, users.id, users.email, users.fk_userrole
                            FROM users
                            WHERE users.id = :id", $get['id']);
    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];
        //print_r($post);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }

        if(isset($post['opretBruger']))
        {
            $navn    = validCharacter($post['navn']) ? $post['navn']           : $error['navn']     = 'navn skal udfyldes, og må ikke indeholde tal.';
            $mail        = validEmail($post['email']) ? $post['email']                   : $error['email']       = 'Email skal udfyldes og være en gyldig email adresse.';
            $cat 		= isset($post['cat']) ? $post['cat'] 									: $error['bruger'] 		= 'fejl besked bruger!';
            if(sizeof($error) === 0){
                            
                            if (!sqlQueryPrepared('
                                UPDATE users SET `navn` = :navn, `email`= :mail, `fk_userrole` = :userrole WHERE id = :id
                                ',array(
                                    ':navn' => $navn,
                                    ':mail' => $mail,
                                    ':userrole' => $cat,
                                    ':id' => $get['id']
                                ))) {
                                                                echo 'test';

                                    $error['brugeropret'] = 'Der skete en fejl ved oprettelse. SCRUB!';
                                }
                                else {
                                    header('Location: ?p=dashboard&view=users');
                                }
                        }
                    }
                    else {
                        $error['generel'] = 1801; // execute fejl
                    }
                }
                else {
                    $error['generel'] = 1802; // prepare fejl
                }
                
            
                $stmt = $conn->prepare("SELECT navn, id FROM userroles WHERE niveau <= 90");
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_OBJ); 
            }


?>

<h1>Rediger Bruger</h1>
<div class="container">
<div class="row">



<form class="col-md-12" enctype="multipart/form-data" action="" method="post" id="eventForm">
<?php 
    if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
    if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
?>
<?=secCreateTokenInput()?>
    <div class="col s6">
    <div class="form-group col-md-12">
        <label for="navn">Navn</label><br />
        <input class="form-control" type="text" name="navn" value="<?php echo $collect['navn']; ?>" id="navn" min="2" max="30"><br />
        <?php
            if (isset($error['navn'])) echo '<div class="alert alert-danger">'.$error['navn'].'</div>'.PHP_EOL;
        ?>
    </div>
    <div class="form-group col-md-12">
        <label for="email">Email</label><br />
        <input class="form-control" type="email" name="email" value="<?php echo $collect['email']; ?>" id="email"><br />
        <?php
        if (isset($error['email'])) echo '<div class="alert alert-danger">'.$error['email'].'</div>'.PHP_EOL;
    ?>
        
    </div>
    <div class="form-group col-md-12">
    <label for="cat">Status</label>
    <select name="cat" class="custom-select">
    <?php foreach($stmt->fetchAll() as $value){
        $selected = '';
        if($value->id == $collect['fk_userrole']) {
            $selected = 'selected';
        }
        echo '<option '.$selected.' value="'.$value->id.'">'.$value->navn.'</option>';
    }
        ?>
</select>
    </div>
    <div class="form-group col-md-12">
    <button type="submit" class="btn btn-dark" name="opretBruger">Opret Bruger</button>
    </div>
</form>
</div>
</div>