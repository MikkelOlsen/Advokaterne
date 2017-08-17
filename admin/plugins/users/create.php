
<?php
    //print_r('Time: ' . (time() - $_SESSION['TokenAge']));

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
									':userrole' => 1
								))) {
                                                                echo 'test';

									$error['brugeropret'] = 'Der skete en fejl ved oprettelse. SCRUB!';
								}
								else {
									header('Location: ?p=login');
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
                                        //print_r(validTel('34 45 23 23'));
                                        //print_r(validTel($post['tlf']));
                                        //print_r($tel);
                                        //print_r($error);

?>
<div class="container">
<div class="row">
    
<h1 class="center-align"><b>Opret Bruger</b></h1>


<form class="col s12" action="" method="post" id="eventForm">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="col s6">
        <div class="input-field col s12">
            <label for="navn">navn</label><br />
            <input class="validate" type="text" name="navn"  id="navn" min="2" max="30"><br />
            <?php
                if (isset($error['navn'])) echo '<div class="alert alert-danger">'.$error['navn'].'</div>'.PHP_EOL;
            ?>
        </div>
        <div class="input-field col s12">
            <label for="email">Email</label><br />
            <input class="validate" type="email" name="email"  id="email"><br />
            <?php
			if (isset($error['email'])) echo '<div class="alert alert-danger">'.$error['email'].'</div>'.PHP_EOL;
		?>
            
        </div>
        <div class="input-field col s12">
            <label for="kode">Adgangskode</label><br />
            <input class="validate" type="password" name="kode"  id="kode"><br />
            
        </div>
        <div class="input-field col s12">
            <label for="gentagKode">Gentag Adgangskode</label><br />
            <input class="validate" type="password" name="gentagKode"  id="gentagKode"><br /><br />
            <?php
			if (isset($error['kodematch'])) echo '<div class="alert alert-danger">'.$error['kodematch'].'</div>'.PHP_EOL;
			if (isset($error['kodeformat'])) echo '<div class="alert alert-danger">'.$error['kodeformat'].'</div>'.PHP_EOL;
		?>
        </div>
        <button type="submit" class="btn btn-default col-md-3" name="opretBruger">Opret Bruger</button>
</form>
</div>
</div>