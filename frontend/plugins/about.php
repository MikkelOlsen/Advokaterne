<?php
    $collectInfo = getFromDB("SELECT history, purpose, motto
                              FROM information
                              WHERE id = :id", 1);
                              
?>

<section class="container row">
    <section class="col-md-12">
        <h4>HISTORIEN</h4>
        <p><?php echo $collectInfo['history'] ?></p>

        <hr>

        <h4>ADVOKATERNES FORMÅL</h4>
        <p><?php echo $collectInfo['purpose'] ?></p>

        <hr>

        <h4>VIL DU VÆRE EN AF VORES SAMARBEJDSPARTNERE?</h4>
        <p><?php echo $collectInfo['motto'] ?></p>

        <a href="?p=kontakt">
            <p>Kontakt os</p>
        </a>
    
    </section>

<?php
    
?>
    
    <section class="col-md-12 custombox">
        <h4 class="padding-bottom">HVAD KUNDERNE MENER</h4>

        <div class="row">

        <?php
    $stmtTesti = $conn->prepare("SELECT name, story
    FROM testimonials
    ORDER BY RAND()
    LIMIT 4");
    $stmtTesti->execute();

    $resultTest = $stmtTesti->setFetchMode(PDO::FETCH_OBJ);

    foreach($stmtTesti->fetchAll() as $value) {
        echo 
        '
            <div class="col-md-6">
                <p>'.$value->story.'</p>
                <p class="text-right"><i>- '.$value->name.'</i></p>
            </div>      
        ';
    }

?>
        </div>
    </section>

    
</section>