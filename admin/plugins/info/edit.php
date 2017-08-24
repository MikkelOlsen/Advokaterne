<?php
	if(secCheckLevel() < 50){
		die();
	}
    $error = [];
    $infoID = '1';
    $collect = getFromDB("SELECT history, purpose, motto, fk_img FROM information WHERE id = :id", $infoID);
	if(secCheckMethod('POST')){
        $post = secGetInputArray(INPUT_POST);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		= [];
        $history = validMixedBetween($post['historie'], 1, 511) ? $post['historie'] 	: $error['historie'] = 'fejl besked historie!';
        $purpose = validMixedBetween($post['purpose'], 1, 511) ? $post['purpose'] 	: $error['purpose'] = 'fejl besked purpose!';
        $motto = validMixedBetween($post['motto'], 1, 511) ? $post['motto'] 	: $error['motto'] = 'fejl besked motto!';
		if(sizeof($error) === 0){
            if($_FILES['filUpload']['error'] == 4) {
                sqlQueryPrepared(
                "
                    UPDATE `information` SET `history` = :history, `purpose` = :purpose, `motto` = :motto WHERE id = :id
                ",
                array(
                    ':history' => $history,
                    ':purpose' => $purpose,
                    ':motto' => $motto,
                    ':id' => $infoID
                ));
                header('Location: ?p=dashboard&view=information');
            } else {
            $billede = mediaImageUploader('filUpload');
            if($billede['code']) {
                $collectImage = getFromDB("SELECT media.path, media.id
                                           FROM media
                                           INNER JOIN information
                                           ON media.id = information.fk_img
                                           WHERE information.id = :id", $infoID);   
                $imgID = $collectImage['id'];
                $sti = './media/'.$collectImage['path'];
            
            if(sqlQueryPrepared(
                    "
                        UPDATE `media` SET `path` = :path WHERE `id` = :img;
						UPDATE `information` SET `history` = :history, `purpose` = :purpose, `motto` = :motto WHERE id = :id
					",
					array(
                        ':history' => $history,
                        ':purpose' => $purpose,
                        ':motto' => $motto,
                        ':img' => $imgID,
                        ':path' => $billede['name'],
						':id' => $infoID
					)
				)) {
                    if(file_exists($sti)) {
                        unlink($sti);
                        echo 'success!';
                    } else {
                        echo 'Naaah';
                    }
                    header('Location: ?p=dashboard&view=information');
                }
             } else {
                    $error['filUpload'] = $billede['msg'];
                }
        }
    }
	}
    //print_r($error);
    //print_r($inst);
?>

<h1>Om os siden</h1>
<div class="container">
<div class="row">
    


<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="col s6">
        <div class="input-field col s12">
        <label for="historie">Historie</label>
		<textarea name="historie" class="form-control"><?php echo $collect['history'] ?></textarea>
        </div>

        <div class="input-field col s12">
        <label for="purpose">Advokaternes formål</label>
		<textarea name="purpose" class="form-control"><?php echo $collect['purpose'] ?></textarea>
        </div>

        <div class="input-field col s12">
        <label for="motto">Vil du være en af vores samarbejdspartnere?</label>
		<textarea name="motto" class="form-control"><?php echo $collect['motto'] ?></textarea>
        </div>

        <div class="col-md-12">
			<label class="custom-file">
				<span class="custom-file-control">Billede</span>
				<input name="filUpload" class="custom-file-input" type="file">
			</label>
			
		</div>
        </div>
        <button type="submit" class="btn btn-default col-md-3" name="opretBruger">Gem ændringer</button>
        </div>
</form>
</div>
</div>