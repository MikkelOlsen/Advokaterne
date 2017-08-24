<h4 class="maintext">DETTE ER HVAD VI TILBYDER - VORES SERVICES</h4>

<hr>

<div class="container">
    <div class="container row">
        <div class="container">
            <h3>DETTE ER EN LISTE OVER VORES SERVICES</h3>
            <p>En kort beskrivelse af hvad “advokaterne” tilbyder af services.</p>
        </div>
    <?php
        $stmtServices = $conn->prepare("SELECT serviceName, serviceText
                                        FROM services");
        $stmtServices->execute();

        $resultServices = $stmtServices->setFetchMode(PDO::FETCH_OBJ);

        foreach($stmtServices->fetchAll() as $value) {
            echo
            '
            <div class="col-md-6">
                <div class="container">
                    <h5>'.$value->serviceName.'</h5>  
                    <p>'.$value->serviceText.'</p>          
                </div>            
                <hr>
            </div>
            ';
        }
    ?>
        

    </div>
</div>