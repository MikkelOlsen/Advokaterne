<?php
        include_once '/includes/header.php';

        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['view']) && !empty($get['view'])) {
                switch ($get['view']) {

                    case 'home';
                        include_once '/home.php';
                        break;

                    case 'create';
                        include_once '/admin/plugins/users/create.php';
                        break;

                   

                    


                    default: 
                        header('Location: ?p=dashboard&view=home');
                        break;
                }
            }
            else {
            header('Location: ?p=dashboard&view=home');
            }
            
        }

?>