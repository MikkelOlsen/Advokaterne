<?php
if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=viskat');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=viskat');
    exit;
}

if(getFromDB("SELECT id FROM blogpost WHERE fk_cat = :id", $get['id'])) {
    echo 'Du kan ikke slette en kategori hvor der er posts tilknyttet </br>
    <a href="?p=dashboard&view=viskat"><button type="button" class="btn btn-dark">Gå Tilbage</button></a>';
} else {
    if(sqlQueryPrepared("DELETE FROM blogcategory WHERE id = :id", array(':id' => $profileId))) {
        header('Location: ?p=dashboard&view=viskat');
    } else {
        echo 'Der skete en fejl ved slettelsen af kategorien, prøv igen.';
    }
}
