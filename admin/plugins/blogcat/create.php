<h1>Ny blogkategori</h1>


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
            $navn = validStringBetween($post['navn'], 2, 25) ? $post['navn'] : $error['navn'] = 'Fejl i kategoriens navn.';
            if(sizeof($error) === 0){
				if ($stmt = $conn->prepare("SELECT id FROM blogcategory WHERE categoryName = :navn")) {
					$stmt->bindParam(':navn', $navn, PDO::PARAM_STR);
					if ($stmt->execute()) {
                        echo 'successs';
						if ($stmt->rowCount() > 0) {
							$error['brugerfindes'] = 'Den kategori, du prøver at oprette, ekstisterer allerede.';
						}
						else {
                            
							if (!sqlQueryPrepared('
								INSERT INTO `blogcategory`(`categoryName`) 
								VALUES (:navn)
								',array(
									':navn' => $navn
								))) {
                                                                echo 'test';

									$error['brugeropret'] = 'Der skete en fejl ved oprettelse. SCRUB!';
								}
								else {
									header('Location: ?p=dashboard&view=nykat');
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
    


<form class="col s12" action="" method="post" id="eventForm">
    <?php 
        if (isset($error['brugerfindes'])) echo '<div class="alert alert-danger">'.$error['brugerfindes'].'</div>'.PHP_EOL;
        if (isset($error['brugeropret'])) echo '<div class="alert alert-danger">'.$error['brugeropret'].'</div>'.PHP_EOL;
    ?>
    <?=secCreateTokenInput()?>
        <div class="col s6">
        <div class="form-group col-md-12">
            <label for="navn">Kategori navn</label><br />
            <input class="form-control" type="text" name="navn"  id="navn" min="2" max="30"><br />
            <?php
                if (isset($error['navn'])) echo '<div class="alert alert-danger">'.$error['navn'].'</div>'.PHP_EOL;
            ?>
        <button type="submit" class="btn btn-dark" name="opretBruger">Opret Kategori</button>
        </div>
</form>
</div>
</div>