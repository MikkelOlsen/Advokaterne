<?php
	if(secCheckLevel() < 90){
		die();
	}

    $collect = getFromDB("SELECT id, name, story
                          FROM testimonials
                          WHERE id = :id", $get['id']);

	$error=[];
	if(secCheckMethod('POST')){
		$post = secGetInputArray(INPUT_POST);
		if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		 = [];
		$post    		 = secGetInputArray(INPUT_POST);
        $name            = validStringBetween($post['name'], 2, 30) ? $post['name']                 : $error['name'] = 'Fejl i navnet';
		$story 	         = validMixedBetween($post['story'], 1, 511) ? $post['story'] 	: $error['story'] = 'fejl i kundeudtalelsen!';
		if(sizeof($error) === 0){
				//echo 'tom';
                if(sqlQueryPrepared(
                "
					UPDATE 
                    `testimonials`
                    SET
                    `name` = :name,
                    `story` = :story
                    WHERE
                    id = :id
                ",
					array(
						':story' => $story,
                        ':name' => $name,
                        ':id' => $get['id']
					))) {
                        header('Location: ?p=dashboard&view=udtalelser');
                    }
			}
            }
?>


<div class="container">
	<div class="row">
		<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
        <div class="form-group col-md-12">
            <label for="name">Navn</label><br />
            <input class="form-control" type="text" name="name" value="<?php echo $collect['name'] ?>" id="name" min="2" max="30"><br />
        </div>
		<div class="form-group col-md-12">
		<label for="story">Kunde Udtalelse</label>
		<textarea name="story" class="form-control"><?php echo $collect['story'] ?></textarea>
        </div>
			<div class="col-md-12">
			<button name="opretUdtalelse" class="btn btn-dark" type="submit">Opret</button>
			</div>				
</form>		
	</div>
</div>

