<?php
	if(secCheckLevel() < 90){
		die();
    }
    $collect = getFromDB("SELECT blogpost.id as blogID, postTitle, postText, blogpost.date, media.path, users.navn, blogcategory.categoryName, blogcategory.id AS catID
    FROM blogpost
    INNER JOIN media
    ON blogpost.fk_img = media.id
    INNER JOIN users
    ON blogpost.fk_user = users.id
    INNER JOIN blogcategory 
    ON blogpost.fk_cat = blogcategory.id
    WHERE blogpost.id = :id", $get['id']);

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
        $cat 		= isset($post['cat']) ? $post['cat'] 									: $error['bruger'] 		= 'fejl besked bruger!';
		if(sizeof($error) === 0){
            if($_FILES['filUpload']['error'] == 4) {
				//echo 'tom';
                sqlQueryPrepared(
                    "
                    UPDATE `blogpost` SET `postTitle` = :title, `postText` = :text, `fk_cat` = :cat WHERE id = :postID
                ",
                array(
                    ':title' => $title,
                    ':text' => $beskrivelse,
                    ':cat' => $cat,
                    ':postID' => $get['id']
                ) );
                header('Location: ?p=dashboard&view=editpost&id='.$get['id'].'');
            } else {
				//echo 'billede';
			$billede = mediaImageUploader('filUpload');
			if($billede['code']){
                $collectImage = getFromDB("SELECT media.path, media.id
                FROM media
                INNER JOIN blogpost
                ON media.id = blogpost.fk_img
                WHERE blogpost.id = :id", $get['id']);
                $imgID = $collectImage['id'];
                $sti = './media/'.$collectImage['path'];
				if(sqlQueryPrepared(
					"
                        UPDATE `media` SET `path` = :sti WHERE id = :mediaID;
                        UPDATE `blogpost` SET `postTitle` = :title, `postText` = :text, `fk_cat` = :cat WHERE id = :postID
					",
					array(
                        ':mediaID' => $imgID,
                        ':sti' => $billede['name'],
                        ':title' => $title,
                        ':text' => $beskrivelse,
                        ':cat' => $cat,
                        ':postID' => $get['id']
					)
				)) {
                    if(file_exists($sti)) {
                        unlink($sti);
                        echo 'success!';
                    } else {
                        echo 'Naaah';
                    }
                }
				header('Location: ?p=dashboard&view=editpost&id='.$get['id'].'');
			} else {
				$error['filUpload'] = $billede['msg'];
			}
            }
		}
    } 


    $stmt = $conn->prepare("SELECT categoryName, id FROM blogcategory");
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_OBJ); 
    //print_r($error);
?>

<div class="container">
<img class="blog-img" src="./media/<?php echo $collect['path'] ?>" alt="">
	<div class="row">
		<form action="" method="post" class="col-md-12" enctype="multipart/form-data">
		<?=secCreateTokenInput()?>
        <div class="form-group col-md-12">
            <label for="title">Titel</label><br />
            <input class="form-control" type="text" value="<?php echo $collect['postTitle'] ?>" name="title"  id="title" min="2" max="30"><br />
        </div>
		<div class="form-group col-md-12">
		<label for="beskrivelse">Post</label>
		<textarea name="beskrivelse" class="form-control"><?php echo $collect['postText'] ?></textarea>
        </div>
        <div class="form-group col-md-12">
		<select name="cat" class="custom-select">
			<?php foreach($stmt->fetchAll() as $value){
                $selected = "";                
                if($value->id === $collect['catID']) {
                    $selected = "selected";
                }
				echo '<option '.$selected.' value="'.$value->id.'">'.$value->categoryName.'</option>';
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
			<button name="opretStil" class="btn btn-dark" type="submit">Opdater</button>
			</div>				
</form>		
	</div>
</div>
