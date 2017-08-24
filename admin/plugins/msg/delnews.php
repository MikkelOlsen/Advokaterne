<?php
if(isset($get['id']) && !empty($get['id'])){
    if(secCheckLevel() >= 90) {
        $profileId = $get['id'];
    } else {
        header('Location: ?p=dashboard&view=nyhedsbreve');
        exit;
    }
}else{
    echo 'fejl i id get';
    header('Location: ?p=dashboard&view=nyhedsbreve');
    exit;
}
    if(sqlQueryPrepared("DELETE FROM newsletter WHERE id = :id", array(':id' => $profileId))) {
        header('Location: ?p=dashboard&view=nyhedsbreve');
    } else {
        echo 'Der skete en fejl ved slettelsen af den tilmeldte, prøv igen.';
    }
