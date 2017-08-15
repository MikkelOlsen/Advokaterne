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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Advokaterne</title>
<!-- Latest compiled and minified CSS -->
 <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="./frontend/assets/css/style.css">
  <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

</head>
<body>


<?php

?>
<main>

  
    <?php
        if(secCheckMethod('GET') || secCheckMethod('POST')) {
            $get = secGetInputArray(INPUT_GET);
            if(isset($get['p']) && !empty($get['p'])) {
                switch ($get['p']) {


                    // OVERALL CASES
                    case 'login' :
                        include_once './frontend/plugins/users/login.php';
                        break;
                    case 'logout';
                        include_once './frontend/plugins/users/logout.php';
                        break;
                    case 'frontpage';
                        include_once './frontend/plugins/frontpage.php';
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

            
  
</main>
    <?php
        include_once './frontend/includes/footer.php';
        
    ?>
</body>
</html>
