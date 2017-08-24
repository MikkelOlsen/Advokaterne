<?php
if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=beskeder');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=beskeder');
    exit;
}
    if(sqlQueryPrepared("DELETE FROM messages WHERE id = :id", array(':id' => $profileId))) {
        header('Location: ?p=dashboard&view=beskeder');
    } else {
        echo 'Der skete en fejl ved slettelsen af beskeden, prøv igen.';
    }
