<?php
include_once '../config/database.php';
include_once '../models/Pilgrim.php';
include_once '../services/MonnifyService.php';

$database = new Database();
$db = $database->getConnection();
$pilgrim = new Pilgrim($db);
$monnifyService = new MonnifyService();

// Register a new pilgrim
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
    $pilgrim->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $accountNumber = $monnifyService->createReservedAccount($pilgrim);
        $pilgrim->account_number = $accountNumber;

        if ($pilgrim->create()) {
            header('Location: ../../public/index.php');
        } else {
            echo "Registration failed. Please try again.";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// Fetch transactions for a pilgrim's reserved account
if (isset($_POST['fetch_transactions'])) {
    $pilgrim->email = $_POST['email'];
    if ($pilgrim->getPilgrimByEmail()) {
        try {
            $transactions = $monnifyService->fetchReservedAccountTransactions($pilgrim->account_reference);
            // Display the transactions
            echo "<h1>Transactions for Account Reference: " . $pilgrim->account_reference . "</h1>";
            echo "<table>";
            echo "<tr><th>Date</th><th>Amount</th><th>Currency</th><th>Payment Status</th></tr>";
            foreach ($transactions as $transaction) {
                echo "<tr>";
                echo "<td>" . $transaction['transactionDate'] . "</td>";
                echo "<td>" . $transaction['amountPaid'] . "</td>";
                echo "<td>" . $transaction['currency'] . "</td>";
                echo "<td>" . $transaction['paymentStatus'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Pilgrim not found";
    }
}
?>
