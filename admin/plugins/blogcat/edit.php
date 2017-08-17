<?php
	if(secCheckLevel() < 50){
		die();
	}
    $error = [];
    $collect = getFromDB("SELECT categoryName FROM blogcategory WHERE id = :id", $get['id']);
	if(secCheckMethod('POST')){
        $post = secGetInputArray(INPUT_POST);
        if(!secValidateToken($post['_once'], 600)) {
            $error['session'] = 'Din session er udløbet. Prøv igen.';
        }
		$error   		= [];
        $navn            = validStringBetween($post['navn'], 2, 25) ? $post['navn']                 : $error['navn'] = 'Fejl i kategoriens navn';
		if(sizeof($error) === 0){
			if(sqlQueryPrepared(
					"
						UPDATE `blogcategory` SET `categoryName` = :navn WHERE id = :id
					",
					array(
                        ':navn' => $navn,
						':id' => $get['id']
					)
				)) {
                    header('Location: ?p=dashboard&view=viskat');
                } else {
                    $error['SQL'] = 'Fejl i rettelse af niveau, prøv igen.';
                }
        }
	}
    //print_r($error);
    //print_r($inst);
?>

<h1>Ny blogkategori</h1>
<div class="container">
<div class="row">
    


<form class="col s12" action="" method="post" id="eventForm">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="col s6">
        <div class="input-field col s12">
            <label for="navn">Kategori navn</label><br />
            <input class="validate" type="text" name="navn" value="<?php echo $collect['categoryName'] ?>" id="navn" min="2" max="30"><br />
            <?php
                if (isset($error['navn'])) echo '<div class="alert alert-danger">'.$error['navn'].'</div>'.PHP_EOL;
            ?>
        <button type="submit" class="btn btn-default col-md-3" name="opretBruger">Gem ændringer</button>
        </div>
</form>
</div>
</div>