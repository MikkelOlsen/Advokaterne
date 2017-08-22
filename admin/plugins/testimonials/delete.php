<?php

if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=udtalelser');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=udtalelser');
    exit;
}

if(sqlQueryPrepared("DELETE FROM testimonials WHERE id = :id", array(':id' => $profileId))) {
    header('Location: ?p=dashboard&view=udtalelser');
} else {
    echo 'Der skete en fejl ved slettelsen af udtalelsen, prøv igen.';
}