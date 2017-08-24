<?php
  if(secCheckMethod('POST')) {
    $post = secGetInputArray(INPUT_POST);
    $error = [];
    $name = validStringBetween($post['senderName'], 2, 45) ? $post['senderName'] : $error['senderName'] = '<div class="alert alert-danger">Der er fejl i navnet.</div>';
    $email = validEmail($post['senderEmail']) ? $post['senderEmail'] : $error['senderEmail'] = '<div class="alert alert-danger">Dette er ikke en gyldig email.</div>';
    $msg = validMixedBetween($post['senderMsg'], 1, 511) ? $post['senderMsg'] : $error['senderMsg'] = '<div class="alert alert-danger">Der er fejl i din besked.</div>';

    if(sizeof($error) === 0) {
      if(sqlQueryPrepared(
        "
          INSERT INTO `messages`(`senderName`, `senderEmail`, `senderMsg`) VALUES (:senderName, :senderEmail, :senderMsg);
        ",
        array(
          ':senderName' => $name,
          ':senderEmail' => $email,
          ':senderMsg' => $msg
        ) 
      )) {
        $success = '<div class="alert alert-success" role="alert">Din besked er nu sendt! Vi vender tilbage med svar hurtigst muligt!</div>';
      } 
      else {
        $success = '<div class="alert alert-warning" role="alert">Der skete en fejl ved afsendelsen af din besked. Prøv igen.</div>';
      }
    } else {
      $success = '<div class="alert alert-danger" role="alert">Din besked blev ikke sendt! Se fejlbeskederne!</div>';
    }
  }
?>

<h1 style="padding-bottom: 70px; padding-top: 20px;">VI VIL GERNE HØRE FRA DIG</h1>
<?php
                    if(!empty($success)) {
                        echo $success;
                    }
                ?>
<div class="container row">
    <div class="col-lg-7">
        <h4>KONTAKT</h4>
        <p><?php echo $sitesettings['contactMsg'] ?></p>

        <h4>ADRESSE</h4>
        <?php
          echo 
          '
          <p>
          Adresse: '.$sitesettings['siteAdress'].'<br>
          By: '.$sitesettings['siteCity'].'<br>
          Postnummer: '.$sitesettings['siteZip'].'
          </p>
          ';
        ?>

        <h4>EMAIL</h4>
        <p><?php echo $sitesettings['siteEmail'] ?></p>

        <h4>TELEFON</h4>
        <p><?php echo $sitesettings['sitePhone'] ?></p>
        <hr>
    </div>

    <div class="col-lg-7">
        
<div class="container">

  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group row">
      <label for="senderName" class="col-sm-2 col-form-label">Dit navn</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="senderName" id="name">
      </div>
    </div>
      <?=@$error['senderName']?>
    <div class="form-group row">
      <label for="senderEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="senderEmail" id="email">
      </div>
    </div>
    <?=@$error['senderEmail']?>
    <div class="form-group row">
      <label for="senderMsg" class="col-sm-2 col-form-label">Besked</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="senderMsg" id="msg"></textarea>
      </div>
    </div>
    <?=@$error['senderMsg']?>
    <div class="form-group row">
        <label for="send" class="col-sm-2"></label>
      <div class="col-sm-10">
        <button type="submit" name="send" class="btn btn-inverse">Send besked</button>
      </div>
    </div>
  </form>
</div>        

    </div>
</div>