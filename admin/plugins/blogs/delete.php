<?php

if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=posts');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=posts');
    exit;
}

$img = $conn->prepare("SELECT path, media.id AS medId
                       FROM media 
                       INNER JOIN blogpost 
                       ON media.id = blogpost.fk_img 
                       WHERE blogpost.id = :id");
$img->bindParam(':id', $profileId, PDO::PARAM_INT);
$img->execute();

$media = $img->fetch(PDO::FETCH_OBJ);

$image = $media->medId;
$sti = './media/'.$media->path;

echo $image;

if(sqlQueryPrepared("DELETE FROM blogpost WHERE id = :id", array(':id' => $profileId))) {
        if(sqlQueryPrepared("DELETE FROM media WHERE id = :id", array(':id' => $image))){
            echo 'gik i stå';
            if(file_exists($sti)) {
                unlink($sti);
                echo 'success!';
            } else {
                echo 'Naaah';
            }
        } else {
            echo 'nope';
        }
    header('Location: ?p=dashboard&view=posts');
} else {
    echo 'Der skete en fejl ved slettelsen af posten, prøv igen.';
}