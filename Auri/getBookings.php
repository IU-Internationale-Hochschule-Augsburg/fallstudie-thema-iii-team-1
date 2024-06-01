<?php
require 'db.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM bookings");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($bookings);
?>
