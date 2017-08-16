<?php
    if(secCheckMethod('POST')) {
        $post = secGetInputArray(INPUT_POST);
        $error = [];
        if(secValidateToken($post['_once'], 300)) {
            $email = validEmail($post['email']) ? $post['email'] : $error['email'] = 'Fejl i email.';
            $password = validMixedBetween($post['key']) ? $post['key'] : $error['key'] = 'Fejl i adgangskode';

            if(sizeof($error) === 0) {
                $stmt = $conn->prepare("SELECT users.id, users.password, users.email
                                        FROM users
                                        WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    $result = $stmt->fetch(PDO::FETCH_OBJ);
                    if(!password_verify($password, $result->password)) {
                        $error['password'] = 'Forkert adgangskode';
                    } else {
                        $_SESSION['userid'] = $result->brugerId;
                        $_SESSION['username'] = $result->email;
                        header('Location: ?p=dashboard');
                    }
                }
            }
        }
    }
?>

<section id="login">
    <div class="container">
    	<div class="row">
    	    <div class="col">
        	    <div class="form-wrap">
                <h1>Admin Login</h1>
                    <form role="form"  method="post" id="login-form" enctype="multipart/form-data" autocomplete="off">
                        <?=secCreateTokenInput()?>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="key" id="key" class="form-control" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
                    </form>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<script>
    function showPassword() {
    
    var key_attr = $('#key').attr('type');
    
    if(key_attr != 'text') {
        
        $('.checkbox').addClass('show');
        $('#key').attr('type', 'text');
        
    } else {
        
        $('.checkbox').removeClass('show');
        $('#key').attr('type', 'password');
        
    }
    
}
</script>