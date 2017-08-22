<h1>Blog posts</h1><?php
    $stmt = $conn->prepare("SELECT services.id, serviceName, serviceText
                            FROM services");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>

      <table class="table">
        <thead>
          <tr>
              <th></th>
              <th>Service</th>
              <th>Tekst</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                $stmtImg = getFromDB("SELECT media.path
                                      FROM media
                                      INNER JOIN services
                                      ON services.fk_img = media.id
                                      WHERE services.id = :id", $value->id);
                echo '<tr>
                        <td><img class="blog-img" src="./media/'.$stmtImg['path'].'" alt=""></td>
                        <td>'.$value->serviceName.'</td>
                        <td>'.$value->serviceText.'</td>
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="blue-text text-lighten-2" href="?p=dashboard&view=editserv&id='.$value->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                <div class="modal fade" id="modal'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->serviceName.'</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Er du sikker på at du vil slette posten <b>'.$value->serviceName.'</b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                        <a href="?p=dashboard&view=delserv&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
                    </div>
                    </div>
                </div>
                </div>
                     ';
            }
          ?>
        </tbody>
      </table>

      <script>
    $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>

</h1>