<?php
	if(secCheckLevel() < 90){
		die();
    }
    $collectImg = getFromDB("SELECT media.path
    FROM media
    INNER JOIN services
    ON services.fk_img = media.id
    WHERE services.id = :id", $get['id']);

    $collect = getFromDB("SELECT services.id, serviceName, serviceText
    FROM services
    WHERE services.id = :id", $get['id']);

    $id = $get['id'];
	$error=[];
	if(secCheckMethod('POST')){
        echo 'LETS GO!';
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
				//echo 'tom';
                sqlQueryPrepared(
                    "
                    UPDATE `services` SET `serviceName` = :title, `serviceText` = :text WHERE id = :postID
                ",
                array(
                    ':title' => $title,
                    ':text' => $beskrivelse,
                    ':postID' => $get['id']
                ) );
                header('Location: ?p=dashboard&view=editserv&id='.$get['id'].'');
            } else {
				//echo 'billede';
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
                $collectImage = getFromDB("SELECT media.path, media.id
                FROM media
                INNER JOIN services
                ON media.id = services.fk_img
                WHERE services.id = :id", $get['id']);
                $imgID = $collectImage['id'];
                $sti = './media/'.$collectImage['path'];
				if(sqlQueryPrepared(
					"   
                        INSERT INTO `media`(`path`, `type`) VALUES (:path, :type);
                        SELECT LAST_INSERT_ID() INTO @lastId;
                        UPDATE `services` SET `serviceName` = :title, `serviceText` = :text, `fk_img` = @lastId WHERE id = :postID
					",
					array(
                        ':path' => $billede['name'],
                        ':type' => $billede['type'],
                        ':title' => $title,
                        ':text' => $beskrivelse,
                        ':postID' => $get['id']
					)
				)) {
                    if(file_exists($sti)) {
                        unlink($sti);
                        echo 'success!';
                        sqlQueryPrepared(
                            "
                            DELETE FROM media WHERE id = :imgid
                            ",
                        array(
                            ':imgid' => $imgID
                        )
                        );
                    } else {
                        echo 'Naaah';
                    }
                }
				header('Location: ?p=dashboard&view=editserv&id='.$get['id'].'');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
            }
		}
    } 


 
    //print_r($error);
?>

<div class="container">
<img class="blog-img" src="./media/<?php echo $collectImg['path'] ?>" alt="">
	<div class="row">
		<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
        <div class="form-group col-md-12">
            <label for="title">Service Navn</label><br />
            <input class="form-control" type="text" value="<?php echo $collect['serviceName'] ?>" name="title"  id="title" min="2" max="30"><br />
        </div>
		<div class="form-group col-md-12">
		<label for="beskrivelse">Service Tekst</label>
		<textarea name="beskrivelse" class="form-control"><?php echo $collect['serviceText'] ?></textarea>
        </div>
		<div class="col-md-12">
			<label class="custom-file">
				<span class="custom-file-control">Billede</span>
				<input name="filUpload" class="custom-file-input" type="file">
			</label>
			
		</div>
			<div class="col-md-12">
			<button name="opretStil" class="btn btn-dark" type="submit">Opdater</button>
			</div>				
</form>		
	</div>
</div>
