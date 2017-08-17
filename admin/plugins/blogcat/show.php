<h1>Blog kategorier</h1>

<?php

    $stmt = $conn->prepare("SELECT id, categoryName
                            FROM blogcategory");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>



      <table class="table">
        <thead>
          <tr>
              <th>#</th>
              <th>Kategori</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
          $count = 1;
            foreach($stmt->fetchAll() as $value) {
                echo '<tr>
                        <td scope="row">'.$count.'</td>
                        <td>'.$value->categoryName.'</td>
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="blue-text text-lighten-2" href="?p=dashboard&view=editcat&id='.$value->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      </tr>';

                echo '
                        <div class="modal fade" id="modal'.$value->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal'.$value->id.'Label">'.$value->categoryName.'</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Er du sikker på at du vil slette kategorien <b>'.$value->categoryName.'</b> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                    <a href="?p=dashboard&view=delcat&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
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
