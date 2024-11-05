<?php
class ErrorLogger {
    private $logFile;
    private $sendEmailAlerts;
    private $adminEmail;

    public function __construct($logFile = "./logging/error_log.txt", $sendEmailAlerts = false, $adminEmail = "wzf5350@gmail.com") {
        // Ensure the directory exists
        $logDir = dirname($logFile);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true); // Creates the directory recursively
        }

        $this->logFile = $logFile;

        // Check if the file exists, and if not, create it
        if (!file_exists($this->logFile)) {
            file_put_contents($this->logFile, ""); // Creates an empty file
        }

        $this->sendEmailAlerts = $sendEmailAlerts;
        $this->adminEmail = $adminEmail;
    }

    public function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $formattedMessage = "[{$timestamp}] ERROR: {$message}\n";

        // Append the error message to the log file
        file_put_contents($this->logFile, $formattedMessage, FILE_APPEND);

        // Send email alert if enabled
        if ($this->sendEmailAlerts) {
            $this->sendEmailAlert($formattedMessage);
        }
    }

    private function sendEmailAlert($message) {
        $subject = "Error Alert";
        $headers = "From: noreply@example.com\r\n" . "Reply-To: noreply@example.com\r\n";

        // Send the email
        mail($this->adminEmail, $subject, $message, $headers);
    }
}