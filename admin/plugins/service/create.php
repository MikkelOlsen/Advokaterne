<?php
	if(secCheckLevel() < 90){
		die();
	}
	$error=[];
	if(secCheckMethod('POST')){
		$post = secGetInputArray(INPUT_POST);
		if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		 = [];
		$post    		 = secGetInputArray(INPUT_POST);
        $title            = validStringBetween($post['title'], 2, 30) ? $post['title']                 : $error['title'] = 'Fejl i stilartens title';
		$beskrivelse 	 = validMixedBetween($post['beskrivelse'], 1, 511) ? $post['beskrivelse'] 	: $error['beskrivelse'] = 'fejl besked beskrivelse!';
		if(sizeof($error) === 0){
            if($_FILES['filUpload']['error'] == 4) {
                sqlQueryPrepared(
                "
					INSERT INTO `services`(`serviceName` ,`serviceText`, `fk_img`) VALUES (:name, :text, :img);
                ",
					array(
						':text' => $beskrivelse,
                        ':name' => $title,
                        ':img' => NULL
					));
            } else {
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
				sqlQueryPrepared(
					"
						INSERT INTO `media`(`path`, `type`) VALUES (:path, :type);
						SELECT LAST_INSERT_ID() INTO @lastId;
						INSERT INTO `services`(`serviceName` ,`serviceText`, `fk_img`) VALUES (:name, :text, @lastid);
					",
					array(
						':path' => $billede['name'],
						':type' => $billede['type'],
						':text' => $beskrivelse,
                        ':name' => $title,
					)
				);
				//header('Location: ?p=dashboard&view=nypost');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
            }
		} else {
            print_r($error);
        }
	} 
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
        <div class="form-group col-md-12">
            <label for="title">Service Navn</label><br />
            <input class="form-control" type="text" name="title"  id="title" min="2" max="30"><br />
        </div>
		<div class="form-group col-md-12">
		<label for="beskrivelse">Service Beskrivelse</label>
		<textarea name="beskrivelse" class="form-control"></textarea>
        </div>
		<div class="col-md-12">
			<label class="custom-file">
				<span class="custom-file-control">Billede</span>
				<input name="filUpload" class="custom-file-input" type="file">
			</label>
			
		</div>
			<div class="col-md-12">
			<button name="opretService" class="btn btn-dark" type="submit">Opret</button>
			</div>				
</form>		
	</div>
</div>
