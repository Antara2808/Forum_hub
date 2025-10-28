<?php
require_once '../config/config.php';
require_once '../app/Core/Database.php';
require_once '../app/Models/Report.php';

try {
    // Test the Report model functionality
    $reportModel = new \Models\Report();
    
    // Test creating a report
    $testReport = [
        'reporter_id' => 1,
        'thread_id' => 1,
        'reason' => 'spam',
        'description' => 'This is a test report'
    ];
    
    $reportId = $reportModel->createReport($testReport);
    
    if ($reportId) {
        echo "<h2>Report Creation Test: PASSED</h2>";
        echo "<p>Created report with ID: " . $reportId . "</p>";
        
        // Test checking if user has reported content
        $hasReported = $reportModel->hasUserReported(1, 'thread', 1);
        echo "<p>User has reported thread: " . ($hasReported ? "YES" : "NO") . "</p>";
        
        // Test getting report details
        $report = $reportModel->getReportWithDetails($reportId);
        if ($report) {
            echo "<h2>Report Details Test: PASSED</h2>";
            echo "<pre>" . print_r($report, true) . "</pre>";
        } else {
            echo "<h2>Report Details Test: FAILED</h2>";
        }
        
        // Clean up - delete the test report
        $db = \Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM reports WHERE id = ?");
        $stmt->execute([$reportId]);
        echo "<p>Cleaned up test report</p>";
    } else {
        echo "<h2>Report Creation Test: FAILED</h2>";
    }
} catch (Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}