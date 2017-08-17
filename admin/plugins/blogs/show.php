<h1>Blog posts</h1><?php
    $stmt = $conn->prepare("SELECT blogpost.id, postTitle, postText, blogpost.date, media.path, users.navn, blogcategory.categoryName
                            FROM blogpost
                            INNER JOIN media
                            ON blogpost.fk_img = media.id
                            INNER JOIN users
                            ON blogpost.fk_user = users.id
                            INNER JOIN blogcategory 
                            ON blogpost.fk_cat = blogcategory.id
                            ORDER by blogpost.date DESC");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
?>

      <table class="table">
        <thead>
          <tr>
              <th></th>
              <th>Titel</th>
              <th>Post</th>
              <th>Kategori</th>
              <th>Forfatter</th>
              <th>Dato</th>
              <th></th>
              <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
            foreach($stmt->fetchAll() as $value) {
                $dato = date('d/m/Y', strtotime($value->date));
                echo '<tr>
                        <td><img class="blog-img" src="./media/'.$value->path.'" alt=""></td>
                        <td>'.$value->postTitle.'</td>
                        <td>'.$value->postText.'</td>
                        <td>'.$value->categoryName.'</td>
                        <td>'.$value->navn.'</td>
                        <td>'.$dato.'</td>       
                        <td><a href="" class="text-danger" data-toggle="modal" data-target="#modal'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td><a class="blue-text text-lighten-2" href="?p=dashboard&view=editpost&id='.$value->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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
                        Er du sikker på at du vil slette posten <b>'.$value->postTitle.'</b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                        <a href="?p=dashboard&view=delpost&id='.$value->id.'"><button type="button" class="btn btn-primary">Ja</button></a>
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