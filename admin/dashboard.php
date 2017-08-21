<div class="row">
    <div class="col-md-3">


<?php
        include_once '/includes/header.php';
?>
</div>
<div class="col-md-9 mynav">
<?php
if(secIsLoggedIn()) {
@$user = userGet($_SESSION['userid']);
//print_r($user);
        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['view']) && !empty($get['view'])) {
                switch ($get['view']) {
                    //OVERALL CASES
                    case 'home';
                        include_once '/plugins/home.php';
                        break;
                    case 'logout';
                        include_once '/plugins/logout.php';
                        break;


                    //BLOG CASES
                    case 'nypost';
                        include_once '/plugins/blogs/create.php';
                        break;
                    case 'posts';
                        include_once '/plugins/blogs/show.php';
                        break;
                    case 'delpost';
                        include_once '/plugins/blogs/delete.php';
                        break;
                    case 'editpost';
                        include_once '/plugins/blogs/edit.php';
                        break;


                    //BLOG CATEGORy CASES
                    case 'nykat';
                        include_once '/plugins/blogcat/create.php';
                        break;
                    case 'viskat';
                        include_once '/plugins/blogcat/show.php';
                        break;
                    case 'delcat';
                        include_once '/plugins/blogcat/delete.php';
                        break;
                    case 'editcat';
                        include_once '/plugins/blogcat/edit.php';
                        break;


                    //USER CASES
                    case 'usercreate';
                        include_once '/admin/plugins/users/create.php';
                        break;
                    case 'users';
                        include_once '/admin/plugins/users/show.php';
                        break;
                    case 'deluser';
                        include_once '/admin/plugins/users/delete.php';
                        break;
                    case 'edituser';
                        include_once '/admin/plugins/users/edit.php';
                        break;

                    
                    //INFORMATION CASES
                    case 'information';
                        include_once '/admin/plugins/info/edit.php';
                        break;

                    
                    //SERVICE CASES
                    case 'nyservice';
                        include_once '/admin/plugins/service/create.php';
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
        } else {
            header('Location: ?p=login');
        }

?>
</div>

</div>