<?php
    ob_start();
    
    require_once './lib/security.php';
    require_once './sqlconfig.php';
    require_once './lib/sqlOperations.php';
    require_once './lib/validate.php';
    require_once './lib/user.php';
    require_once './lib/media.php';
    @$user = userGet($_SESSION['userid']);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Advokaterne</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./frontend/assets/css/style.css">
  <!-- Include jQuery -->

</head>
<body>


<?php
    include_once './frontend/includes/header.php';
?>
<main>
<div class="container">
  
    <?php
        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['p']) && !empty($get['p'])) {
                switch ($get['p']) {


                    // OVERALL CASES
                    case 'login';
                        include_once './admin/plugins/login.php';
                        break;
                    case 'logout';
                        include_once './frontend/plugins/users/logout.php';
                        break;
                    case 'home';
                        include_once './frontend/plugins/frontpage.php';
                        break;

                    //PAGE CASES
                    case 'services';
                        include_once './frontend/plugins/services.php';
                        break;
                    case 'blog';
                        include_once './frontend/plugins/blog.php';
                        break;
                    case 'omos';
                        include_once './frontend/plugins/about.php';
                        break;
                    case 'kontakt';
                        include_once './frontend/plugins/contact.php';
                        break;

                    //ADMIN CASES
                    case 'admin';
                        include_once './admin/plugins/login.php';
                        break;
                    case 'dashboard';
                        include_once './admin/dashboard.php';
                        break;


                    


                    default: 
                        header('Location: ?p=frontpage');
                        break;
                }
            }
            else {
            header('Location: ?p=frontpage');
            }
            
        }

    ?>

            
  </div>
</main>
    <div class="container">
    <?php
        include_once './frontend/includes/footer.php';
        
?>
</div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script>
        var url = window.location.href;
        $('.menu a').filter(function() {
            return this.href == url;
        }).addClass('active');
</script>
</body>
</html>
