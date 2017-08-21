<?php
    $posts = $conn->prepare("SELECT blogpost.id
        FROM blogpost");
$posts->execute();
$countPost = 0;

$result = $posts->setFetchMode(PDO::FETCH_OBJ);
foreach($posts->fetchAll() as $value) {
    $countPost++;
}

$usersGet = $conn->prepare("SELECT users.id 
                            FROM users
                            INNER JOIN userroles
                            ON users.fk_userrole = userroles.id
                            WHERE userroles.niveau <= 90");
$usersGet->execute();
$countusers = 0;

$resultusers = $usersGet->setFetchMode(PDO::FETCH_OBJ);
foreach($usersGet->fetchAll() as $value2) {
    $countusers++;
}
?>

<h4>Velkommen til administrations panelet.</h4>

<div class="container">
    <div class="row"><h4>Antal blog posts: <?php echo $countPost; ?></h4></div>
    <div class="row"><h4>Antal brugere: <?php echo $countusers; ?></h4></div>
    <div class="row"><h4>Antal visninger denne uge: 367</h4></div>
</div>




