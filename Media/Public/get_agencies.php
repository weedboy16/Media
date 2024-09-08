<?php
include 'components/db_connect.php';

$pro_id = isset($_GET['pro_id']) ? intval($_GET['pro_id']) : 0;

if ($pro_id > 0) {
    // Fetch agencies associated with the selected PRO
    $sql = "SELECT a.id, a.name 
            FROM agencies a 
            JOIN public_relations_officers pro ON pro.agency_id = a.id 
            WHERE pro.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pro_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output agencies as plain text
    $agencies = [];
    while ($agency = $result->fetch_assoc()) {
        $agencies[] = $agency['id'] . '|' . $agency['name'];
    }

    // Return agencies as plain text with each agency on a new line
    header('Content-Type: text/plain');
    echo implode("\n", $agencies);
}
?>
