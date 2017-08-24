<h1>Beskeder fra kunder</h1>

<?php

    $stmt = $conn->prepare("SELECT id, senderName, senderEmail, senderMsg
                            FROM messages");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>



      <table class="table">
        <thead>
          <tr>
              <th>#</th>
              <th>Navn</th>
              <th>Email</th>
              <th>Besked</th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
          $count = 1;
          

            foreach($stmt->fetchAll() as $value) {
                $max_length = 250;
                $longMsg = $value->senderMsg;
                if (strlen($value->senderMsg) > $max_length)
                {
                    $offset = ($max_length - 3) - strlen($value->senderMsg);
                    $value->senderMsg = substr($value->senderMsg, 0, strrpos($value->senderMsg, ' ', $offset)) . '...  <a href="" class="text-primary" data-toggle="modal" data-target="#modalView'.$value->id.'">Læs mere</a>';
                }
                echo '<tr>
                        <td scope="row">'.$count.'</td>
                        <td>'.$value->senderName.'</td>
                        <td>'.$value->senderEmail.'</td>
                        <td>'.$value->senderMsg.'</td>
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <div class="modal fade" id="modal'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->senderName.'</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Er du sikker på at du vil slette beskeden fra <b>'.$value->senderName.'</b> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                    <a href="?p=dashboard&view=delMsg&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
                                </div>
                                </div>
                            </div>
                            </div>';

                    echo '
                            <div class="modal fade" id="modalView'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->senderName.'</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        '.$longMsg.'
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Luk</button>
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
