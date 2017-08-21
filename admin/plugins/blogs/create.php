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
        $cat 		= isset($post['cat']) ? $post['cat'] 									: $error['bruger'] 		= 'fejl besked bruger!';
		if(sizeof($error) === 0){
            if($_FILES['filUpload']['error'] == 4) {
				//echo 'tom';
                sqlQueryPrepared(
                "
					INSERT INTO `blogpost`(`postTitle` ,`postText`, `fk_img`, `fk_user`, `fk_cat`, `date`) VALUES (:title, :beskrivelse, :img, :user, :cat, NOW());
                ",
					array(
						':beskrivelse' => $beskrivelse,
                        ':title' => $title,
                        ':cat' => $cat,
                        ':user' => $user['id'],
                        ':img' => NULL
					));
            } else {
				//echo 'billede';
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
				sqlQueryPrepared(
					"
						INSERT INTO `media`(`path`, `type`) VALUES (:path, :type);
						SELECT LAST_INSERT_ID() INTO @lastId;
						INSERT INTO `blogpost`(`postTitle` ,`postText`, `fk_img`, `fk_user`, `fk_cat`, `date`) VALUES (:title, :beskrivelse, @lastId, :user, :cat, NOW());
					",
					array(
						':path' => $billede['name'],
						':type' => $billede['type'],
						':beskrivelse' => $beskrivelse,
                        ':title' => $title,
                        ':cat' => $cat,
                        ':user' => $user['id']
					)
				);
				//header('Location: ?p=dashboard&view=nypost');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
            }
		}
	} 
    $stmt = $conn->prepare("SELECT categoryName, id FROM blogcategory");
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_OBJ); 
?>

<div class="container">
	<div class="row">
		<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
        <div class="form-group col-md-12">
            <label for="title">Titel</label><br />
            <input class="form-control" type="text" name="title"  id="title" min="2" max="30"><br />
        </div>
		<div class="form-group col-md-12">
		<label for="beskrivelse">Post</label>
		<textarea name="beskrivelse" class="form-control"></textarea>
        </div>
        <div class="form-group col-md-12">
		<select name="cat" class="custom-select">
		<option value="" disabled selected>Kategori</option>
			<?php foreach($stmt->fetchAll() as $value){
				echo '<option value="'.$value->id.'">'.$value->categoryName.'</option>';
			}
				?>
		</select>
		</div>
		<div class="col-md-12">
			<label class="custom-file">
				<span class="custom-file-control">Billede</span>
				<input name="filUpload" class="custom-file-input" type="file">
			</label>
			
		</div>
			<div class="col-md-12">
			<button name="opretStil" class="btn btn-dark" type="submit">Opret</button>
			</div>				
</form>		
	</div>
</div>
