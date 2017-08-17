<?php



function userGet($id) {
    global $conn;
     $stmt = $conn->prepare("SELECT userroles.niveau, users.email, users.navn, users.id
                             FROM users 
                             INNER JOIN userroles
                             ON users.fk_userrole = userroles.id
                             WHERE users.id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
}

function getFromDB($sql, $id) {
    global $conn;
     $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if($stmt->execute() && ($stmt->rowCount() === 1)) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
}