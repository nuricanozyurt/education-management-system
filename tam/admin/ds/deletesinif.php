<?php
include '../../connect.php'; // Veritabanı bağlantı dosyanız

// POST verisini kontrol et
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    if(isset($id)) {
        $stmt = $db->prepare("DELETE FROM siniflar WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
?>

