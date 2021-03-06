<h1>VI ER BILLIGE & <br>VI TAGER ALLE OPGAVER STORE SOM SMÅ</h1>

<section class="container row">
    <section class="col-lg-8">
        
    <div class="row">
        <div class="col">
                <h4>SERVICES</h4>
            <div class="row">
            <?php 
                $stmtServices = $conn->prepare("SELECT id, serviceName, serviceText
                                                FROM services
                                                ORDER BY RAND()
                                                LIMIT 4");
                $stmtServices->execute();

                $resultServices = $stmtServices->setFetchMode(PDO::FETCH_OBJ);

                foreach($stmtServices->fetchAll() as $valueServices) {
                     $stmtImgService = getFromDB("SELECT media.path, services.fk_img
                                      FROM media
                                      INNER JOIN services
                                      ON services.fk_img = media.id
                                      WHERE services.id = :id", $valueServices->id);
                    if(!empty($stmtImgService['fk_img'])) {
                        $servImg = '<img src="./media/'.$stmtImgService['path'].'" class="front-img serviceImg" alt="">';
                    } else {
                        $servImg = '';
                    }
                    echo 
                    '
                        <div class="col-md-5">
                            '.$servImg.'
                            <p>'.$valueServices->serviceName.'</p>
                        </div>
                    ';
                }
                
            ?>
                
        <hr>
            </div>
        </div>
</div>

<div class="row">
    <div class="col">
        <h4>CHEFENS BLOG</h4>
        <?php
            $stmtBlog = $conn->prepare("SELECT blogpost.id, postTitle, postText, blogpost.date
                            FROM blogpost
                            INNER JOIN users
                            ON blogpost.fk_user = users.id
                            INNER JOIN blogcategory 
                            ON blogpost.fk_cat = blogcategory.id
                            ORDER by blogpost.date DESC
                            LIMIT 2");
            $stmtBlog->execute();

            $resultBlog = $stmtBlog->setFetchMode(PDO::FETCH_OBJ);

            foreach($stmtBlog->fetchAll() as $valueBlog) {
                $stmtImgBlog = getFromDB("SELECT media.path, blogpost.fk_img
                                      FROM media
                                      INNER JOIN blogpost
                                      ON blogpost.fk_img = media.id
                                      WHERE blogpost.id = :id", $valueBlog->id);
                $dato = date('d/m/Y', strtotime($valueBlog->date));
                if(!empty($stmtImgBlog['fk_img'])) {
                        $blogImg = '<img src="./media/'.$stmtImgBlog['path'].'" class="front-img blogImg" alt="">';
                } else {
                        $blogImg = '';
                }

                echo 
                '
                    <div class="row">
                        <div class="col-md-3 col-lg-2">
                            '.$blogImg.'
                        </div>         
                        <div class="col-md-8">
                            <p>'.$valueBlog->postTitle.'<br>
                            '.$dato.'<br>
                            '.$valueBlog->postText.' </p>
                        </div>   
                    </div>
                ';
            }
        ?>
        
        
    </div>    
</div>
    </section>

    <section class="col-lg-4 col-md-12">
        <?php
            $stmtInfo = getFromDB("SELECT motto, media.path
                                   FROM information
                                   INNER JOIN media
                                   ON information.fk_img = media.id
                                   WHERE information.id = :id", 1);

                $max_length = 170;

                if (strlen($stmtInfo['motto']) > $max_length)
                {
                    $offset = ($max_length - 3) - strlen($stmtInfo['motto']);
                    $stmtInfo['motto'] = substr($stmtInfo['motto'], 0, strrpos($stmtInfo['motto'], ' ', $offset)) . '...<br>  <a href="?p=omos">Læs mere</a>';
                }

            echo '
                <div class="row">
                    <div class="col">
                                <h4>OM OS</h4>
                    <img src="./media/'.$stmtInfo['path'].'" class="front-img infoImg" alt="">     
                    <p>'.$stmtInfo['motto'].'</p>        
                </div>'
        ?>
        
            <hr>
        </div>
        <div class="row">
            <div class="col">
                <h4>RIS OG ROS</h4>
        <?php
            $stmtTesti = $conn->prepare("SELECT name, story
                            FROM testimonials
                            ORDER BY RAND()
                            LIMIT 3");
            $stmtTesti->execute();

            $resultTest = $stmtTesti->setFetchMode(PDO::FETCH_OBJ);

            foreach($stmtTesti->fetchAll() as $valueTesti) {
                $max_length = 110;

                if (strlen($valueTesti->story) > $max_length)
                {
                    $offset = ($max_length - 3) - strlen($valueTesti->story);
                    $valueTesti->story = substr($valueTesti->story, 0, strrpos($valueTesti->story, ' ', $offset)) . '...<br>  <a href="?p=omos">Læs mere</a>';
                }
                echo 
                '
                    <p>'.$valueTesti->story.'<br>
                    <i>- '.$valueTesti->name.'</i></p>
                ';
            }
        ?>
            </div>
        <hr>
        </div>
<?php
    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];
        $email = validEmail($post['email']) ? $post['email'] : $error['email'] = '<div class="alert alert-danger">Dette er ikke en gyldig email.</div>';
        if(sizeof($error) === 0) {
          if(sqlQueryPrepared(
            "
              INSERT INTO `newsletter`(`email`) VALUES (:email);
            ",
            array(
              ':email' => $email
            ) 
          )) {
            $success = '<div class="alert alert-success" role="alert">Tak fordi du tilmeldte dig vores nyehdsbrev!</div>';
          } 
          else {
            $success = '<div class="alert alert-warning" role="alert">Der skete en fejl ved din tilmelding. Prøv igen.</div>';
          }
        } else {
          $success = '<div class="alert alert-danger" role="alert">Der gik noget galt! Se fejlbeskederne!</div>';
        }
      }
?>
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if(!empty($success)) {
                        echo $success;
                    }
                ?>
                <form action="" name="search" class="form-horizontal" enctype="multipart/form-data" method="POST">
                <label for="email">Tilmeld dig vores nyhedsbrev.</label>
                <div class="input-group">
                <input type="text" class="form-control" name="email" placeholder="Email" aria-label="email">
                <span class="input-group-btn">
                    <button class="btn btn-dark" type="submit">Go!</button>
                </span>
                </div>
                <?=@$error['email']?>
                </form>
            </div>
        </div>
    </section>
</section>
