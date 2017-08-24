<section style="margin-top:60px;" class="row">

    <section class="col-lg-8">

<?php
if(isset($get['blogid']) && !empty($get['blogid'])) {
    $id = $get['blogid'];
    $stmt = $conn->prepare("SELECT blogpost.id, postTitle, postText, DATE_FORMAT(`date`,'%e %b %Y') AS showdate, users.navn, blogcategory.categoryName, DATE_FORMAT(`date`,'%c') AS monthNumber
    FROM blogpost
    INNER JOIN users
    ON blogpost.fk_user = users.id
    INNER JOIN blogcategory 
    ON blogpost.fk_cat = blogcategory.id
    WHERE blogpost.id = $id");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
} else if(isset($get['katid']) && !empty($get['katid'])) {
    $id = $get['katid'];
    $stmt = $conn->prepare("SELECT blogpost.id, postTitle, postText, DATE_FORMAT(`date`,'%e %b %Y') AS showdate, users.navn, blogcategory.categoryName, DATE_FORMAT(`date`,'%c') AS monthNumber
    FROM blogpost
    INNER JOIN users
    ON blogpost.fk_user = users.id
    INNER JOIN blogcategory 
    ON blogpost.fk_cat = blogcategory.id
    WHERE blogcategory.id = $id");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
} else if(isset($get['monthid']) && !empty($get['monthid'])) {
    $id = $get['monthid'];
    $stmt = $conn->prepare("SELECT blogpost.id, postTitle, postText, DATE_FORMAT(`date`,'%e %b %Y') AS showdate, users.navn, blogcategory.categoryName, DATE_FORMAT(`date`,'%c') AS monthNumber
    FROM blogpost
    INNER JOIN users
    ON blogpost.fk_user = users.id
    INNER JOIN blogcategory 
    ON blogpost.fk_cat = blogcategory.id
    WHERE DATE_FORMAT(`date`,'%c') = $id
    ORDER by blogpost.date DESC");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_OBJ);
}

else {
$stmt = $conn->prepare("SELECT blogpost.id, postTitle, postText, DATE_FORMAT(`date`,'%e %b %Y') AS showdate, users.navn, blogcategory.categoryName, DATE_FORMAT(`date`,'%c') AS monthNumber
                        FROM blogpost
                        INNER JOIN users
                        ON blogpost.fk_user = users.id
                        INNER JOIN blogcategory 
                        ON blogpost.fk_cat = blogcategory.id
                        ORDER by blogpost.date DESC");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_OBJ);
}


foreach($stmt->fetchAll() as $value) {
    $stmtImg = getFromDB("SELECT media.path
                            FROM media
                            INNER JOIN blogpost
                            ON blogpost.fk_img = media.id
                            WHERE blogpost.id = :id", $value->id);
    echo 
    '
    <section class="col">
        <h6>'.$value->postTitle.'</h6>
        <p>'.$value->showdate.'<br>
        <i>Af '.$value->navn.'</i></p>
        <div class="row">
            <p class="col">'.$value->postText.'</p>
            <img class="front-img" src="./media/'.$stmtImg['path'].'" alt="">
            </div>
            <p><i>Kategori: '.$value->categoryName.'</i></p>
            <hr>
    </section>
    ';
}
?>



        

    </section>

    <section class="col padding-top">
        <div class="col-lg-12">
            <h6>BLOG NYHEDER</h6>
            <ul class="bloglist">
                <?php
                    $stmtBlog = $conn->prepare("SELECT blogpost.id, postTitle
                    FROM blogpost
                    ORDER by blogpost.date DESC
                    LIMIT 5");
                    $stmtBlog->execute();
                    $resultBlog = $stmtBlog->setFetchMode(PDO::FETCH_OBJ);

                    foreach($stmtBlog->fetchAll() as $valueBlog) {
                        echo '<a href="?p=blog&blogid='.$valueBlog->id.'" class="nav-link social-icon"><li>'.$valueBlog->postTitle.'</li></a>';
                    }
                ?>
            </ul>
        </div>
        <hr>

        <div class="col-lg-12">
            <h6>KATEGORIER</h6>
            <ul class="bloglist">
            <?php
                $stmtCat = $conn->prepare("SELECT blogcategory.id, categoryName
                FROM blogcategory");
                $stmtCat->execute();
                $resultCat = $stmtCat->setFetchMode(PDO::FETCH_OBJ);

                foreach($stmtCat->fetchAll() as $valueBlog) {
                    echo '<a href="?p=blog&katid='.$valueBlog->id.'" class="nav-link social-icon"><li>'.$valueBlog->categoryName.'</li></a>';
                }
            ?>
            </ul>
        </div>
        <hr>

        <div class="col-lg-12">
            <h6>MÅNEDSARKIV</h6>
            <ul class="bloglist">
                <?php
                        for ($i = 0; $i < 5; $i++) {
                          echo '<a href="?p=blog&monthid='.date('n', strtotime("-$i month")).'" class="nav-link social-icon"><li>'.date('F', strtotime("-$i month")).'</li></a>';
                        }
                ?>
            </ul>
        </div>
    </section>

</section>