<?php
class MonnifyService {
    private $authUrl = "https://sandbox.monnify.com/api/v1/auth/login";
    private $baseUrl = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
    private $apiKey = "MK_TEST_67KR3XA58C";
    private $secretKey = "8KB0AUHAHJY8PJSQPVRF99XPM8EQMP5R";
    private $contractCode = "9851006427";

    private function getAccessToken() {
        $ch = curl_init($this->authUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($this->apiKey . ":" . $this->secretKey)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($response, true);

        // Log the response
        $logFile = '../../logs/monnify.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Access Token Response: " . json_encode($response_data) . "\n", FILE_APPEND);

        if ($response_data['requestSuccessful']) {
            return $response_data['responseBody']['accessToken'];
        } else {
            throw new Exception("Failed to get access token: " . $response_data['responseMessage']);
        }
    }

    public function createReservedAccount($pilgrim) {
        $accessToken = $this->getAccessToken();

        $data = [
            "accountReference" => "ref" . time(),
            "accountName" => $pilgrim->pil_name,
            "currencyCode" => "NGN",
            "contractCode" => $this->contractCode,
            "customerEmail" => $pilgrim->email,
            "customerName" => $pilgrim->pil_name,
            "bvn" => $pilgrim->pil_bvn,
            "nin" => $pilgrim->pil_nin,
            "getAllAvailableBanks" => false, // Request for a single account
            "preferredBanks" => ["035"]  // Specify preferred bank codes, here it's Wema Bank (035)
        ];

        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($response, true);

        // Log the response
        $logFile = '../../logs/monnify.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Create Reserved Account Response: " . json_encode($response_data) . "\n", FILE_APPEND);

        if ($response_data['requestSuccessful']) {
            // Find the account for Wema Bank (bank code: 035)
            foreach ($response_data['responseBody']['accounts'] as $account) {
                if ($account['bankCode'] === '035') {
                    // Save account number to pilgrim object
                    $pilgrim->account_number = $account['accountNumber'];

                    // Save account reference to pilgrim object
                    $pilgrim->account_reference = $data['accountReference'];

                    // Update database with account reference
                    if ($pilgrim->updateAccountReference()) {
                        return $account['accountNumber']; // Return account number for Wema Bank
                    } else {
                        throw new Exception("Failed to update account reference in database.");
                    }
                }
            }
            
            throw new Exception("Wema Bank account not found in response.");
        } else {
            throw new Exception("Failed to create reserved account: " . $response_data['responseMessage']);
        }
    }
}

?>