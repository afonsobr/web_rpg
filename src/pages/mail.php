<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Repository\MailRepository;

try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401);
        echo "User not authenticated.";
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $digimonRepo = new DigimonRepository($pdo);
    $mailRepo = new MailRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    if (!$account) {
        http_response_code(404);
        echo "Account not found.";
        exit();
    }

    $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);

    $mailId = isset($_GET['mail_id']) ? (int) $_GET['mail_id'] : null;

    $template = $mailId
        ? '/src/templates/mail/read_mail_template.php'
        : '/src/templates/mail/mail_template.php';

    if ($mailId) {
        $mail = $mailRepo->getSingleMail($account->id, $mailId);
    } else {
        $mailList = $mailRepo->getAccountMailList($account->id) ?? [];
    }

    include $_SERVER['DOCUMENT_ROOT'] . $template;

} catch (Exception $e) {
    http_response_code(500);
    echo "An error occurred while loading data: " . $e->getMessage();
    error_log($e->getMessage());
}
?>