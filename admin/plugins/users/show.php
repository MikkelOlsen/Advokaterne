<h1>Brugere / Medarbejdere</h1>

<?php

    $stmt = $conn->prepare("SELECT users.id, users.navn AS username, users.email, userroles.navn AS stilling
                            FROM users
                            INNER JOIN userroles 
                            ON users.fk_userrole = userroles.id
                            WHERE userroles.niveau <= 90");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>



      <table class="table">
        <thead>
          <tr>
              <th>Navn</th>
              <th>Email</th>
              <th>Stilling</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td>'.$value->username.'</td>
                        <td>'.$value->email.'</td>
                        <td>'.$value->stilling.'</td>
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="blue-text text-lighten-2" href="?p=dashboard&view=edituser&id='.$value->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <div class="modal fade" id="modal'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->username.'</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Er du sikker på at du vil slette brugeren <b>'.$value->username.' - '.$value->stilling.'</b> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                    <a href="?p=dashboard&view=deluser&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
                                </div>
                                </div>
                            </div>
                            </div>';
            }
          ?>
        </tbody>
      </table>


<script>
    $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
