
<?php
    //print_r('Time: ' . (time() - $_SESSION['TokenAge']));

    if(secCheckLevel() <= 90) {
        echo '<h4>Du har desværre ikke rettigheder til at oprette nye brugere.</h4>';
        die();
    } else {
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
                $adgangskode = validMatch($post['gentagKode'], $post['kode']) ? $post['kode']: $error['kodematch']   = 'Dine kodeord matcher ikke.';
                $adgangskode = validMixedBetween($post['kode'], 4) ? $post['kode']           : $error['kodeformat']  = 'Din kode er ikke lang nok.';
                $cat 		= isset($post['cat']) ? $post['cat'] 									: $error['bruger'] 		= 'fejl besked bruger!';
                if(sizeof($error) === 0){
                    if ($stmt = $conn->prepare("SELECT id FROM users WHERE email = :mail")) {
                        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            echo 'successs';
                            if ($stmt->rowCount() > 0) {
                                $error['brugerfindes'] = 'Den bruger, du prøver at oprette, ekstisterer allerede.';
                            }
                            else {
                                
                                $adgangskode = password_hash($adgangskode, PASSWORD_BCRYPT, ['cost' => 12]);
                                if (!sqlQueryPrepared('
                                    INSERT INTO `users`(`email`, `password`, `fk_userrole`, `navn`) 
                                    VALUES (:mail,:pass,:userrole, :navn)
                                    ',array(
                                        ':navn' => $navn,
                                        ':mail' => $mail,
                                        ':pass' => $adgangskode,
                                        ':userrole' => $cat
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
                }
            }
            
        }
        
        $stmt = $conn->prepare("SELECT navn, id FROM userroles WHERE niveau <= 90");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_OBJ); 
                                            //print_r(validTel('34 45 23 23'));
                                            //print_r(validTel($post['tlf']));
                                            //print_r($tel);
                                            //print_r($error);
    }

?>
<h1>Opret Bruger</h1>
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
            <input class="form-control" type="text" name="navn"  id="navn" min="2" max="30"><br />
            <?php
                if (isset($error['navn'])) echo '<div class="alert alert-danger">'.$error['navn'].'</div>'.PHP_EOL;
            ?>
        </div>
        <div class="form-group col-md-12">
            <label for="email">Email</label><br />
            <input class="form-control" type="email" name="email"  id="email"><br />
            <?php
			if (isset($error['email'])) echo '<div class="alert alert-danger">'.$error['email'].'</div>'.PHP_EOL;
		?>
            
        </div>
        <div class="form-group col-md-12">
        <label for="cat">Status</label>
		<select name="cat" class="form-control custom-select">
			<?php foreach($stmt->fetchAll() as $value){
				echo '<option value="'.$value->id.'">'.$value->navn.'</option>';
			}
				?>
		</select>
		</div>
        <div class="form-group col-md-12">
            <label for="kode">Adgangskode</label><br />
            <input class="form-control" type="password" name="kode"  id="kode"><br />
            
        </div>
        <div class="form-group col-md-12">
            <label for="gentagKode">Gentag Adgangskode</label><br />
            <input class="form-control" type="password" name="gentagKode"  id="gentagKode"><br /><br />
            <?php
			if (isset($error['kodematch'])) echo '<div class="alert alert-danger">'.$error['kodematch'].'</div>'.PHP_EOL;
			if (isset($error['kodeformat'])) echo '<div class="alert alert-danger">'.$error['kodeformat'].'</div>'.PHP_EOL;
		?>
        <button type="submit" class="btn btn-dark" name="opretBruger">Opret Bruger</button>
        </div>
</form>
</div>
</div>