<h1>Tilmeldte til nyhedsbeve</h1>

<?php

    $stmt = $conn->prepare("SELECT id, email
                            FROM newsletter");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>



      <table class="table">
        <thead>
          <tr>
              <th>#</th>
              <th>Email</th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
          $count = 1;
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td scope="row">'.$count.'</td>
                        <td>'.$value->email.'</td>
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <div class="modal fade" id="modal'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->email.'</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Er du sikker på at du vil slette den tilmeldte - <b>'.$value->email.'</b> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                    <a href="?p=dashboard&view=delNews&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
                                </div>
                                </div>
                            </div>
                            </div>';
                    $count++;
            }
          ?>
        </tbody>
      </table>


<script>
    $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
