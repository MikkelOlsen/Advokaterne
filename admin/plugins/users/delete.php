<?php
if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=users');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=users');
    exit;
}

    if(sqlQueryPrepared("DELETE FROM users WHERE id = :id", array(':id' => $profileId))) {
        header('Location: ?p=dashboard&view=users');
    } else {
        echo 'Der skete en fejl ved slettelsen af kategorien, prøv igen.';
    }
