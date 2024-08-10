<?php
include_once '../../config/database.php';
include_once '../models/Pilgrim.php';
include_once '../services/MonnifyService.php';

$database = new Database();
$db = $database->getConnection();
$pilgrim = new Pilgrim($db);
$monnifyService = new MonnifyService();

if (isset($_POST['register'])) {
    $pilgrim->pil_name = $_POST['pil_name'];
    $pilgrim->pil_lga = $_POST['pil_lga'];
    $pilgrim->pil_nin = $_POST['pil_nin'];
    $pilgrim->pil_bvn = $_POST['pil_bvn'];
    $pilgrim->passport_no = $_POST['passport_no'];
    $pilgrim->gender = $_POST['gender'];
    $pilgrim->dob = $_POST['dob'];
    $pilgrim->phone_number = $_POST['phone_number'];
    $pilgrim->email = $_POST['email'];
    $pilgrim->password = $_POST['password'];

    try {
        $pilgrim->account_number = $monnifyService->createReservedAccount($pilgrim);

        if ($pilgrim->create()) {
            header('Location: ../../public/index.php');
        } else {
            echo "Registration failed. Please try again.";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
