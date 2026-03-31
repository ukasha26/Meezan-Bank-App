<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// --- DATABASE CONNECTION ---
$host = "localhost";
$port = "5432";
$dbname = "meezan_bank";
$user = "postgres"; // Aapka username
$password = "ukasha123"; // Aapka PostgreSQL password

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'DB Connection Error: ' . $e->getMessage()]));
}

// --- TRANSACTION LOGIC ---
function processTransaction($pdo, $accountNumber, $pin, $amount) {
    // 1. Account aur PIN check karein
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE account_number = ?");
    $stmt->execute([$accountNumber]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$account) return ['success' => false, 'message' => 'Account not found'];
    if ($account['pin'] !== $pin) return ['success' => false, 'message' => 'Invalid PIN'];
    if ($account['balance'] < $amount) return ['success' => false, 'message' => 'Insufficient funds'];

    // 2. Database mein balance UPDATE karein
    $newBalance = $account['balance'] - $amount;
    $updateStmt = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_number = ?");
    $updateStmt->execute([$newBalance, $accountNumber]);

    return [
        'success' => true,
        'message' => 'Transaction successful',
        'new_balance' => $newBalance,
        'dispensed' => $amount
    ];
}

// Handle Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $result = processTransaction($pdo, $input['account'] ?? '', $input['pin'] ?? '', (float)($input['amount'] ?? 0));
    
    header('Content-Type: application/json');
    echo json_encode($result);
}
?>