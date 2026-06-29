<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'db_skpi');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== TUGAS AKHIR ===\n";
$res = $conn->query("SELECT * FROM tugas_akhir");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
