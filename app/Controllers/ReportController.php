<?php

namespace Controllers;

use Core\Controller;
use Models\Report;
use Models\Thread;
use Models\Post;
use Models\User;

class ReportController extends Controller {
    private $reportModel;
    private $threadModel;
    private $postModel;
    private $userModel;

    public function __construct() {
        $this->reportModel = new Report();
        $this->threadModel = new Thread();
        $this->postModel = new Post();
        $this->userModel = new User();
    }

    /**
     * Create a report for content
     */
    public function create() {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $type = $this->post('type');
        $id = intval($this->post('id'));
        $reason = $this->sanitize($this->post('reason'));
        $description = $this->sanitize($this->post('description'));
        
        // Validate report type
        if (!in_array($type, ['thread', 'post', 'user'])) {
            $this->json(['success' => false, 'message' => 'Invalid report type'], 400);
        }
        
        // Check if content exists
        $contentExists = false;
        switch ($type) {
            case 'thread':
                $contentExists = $this->threadModel->find($id) !== false;
                break;
            case 'post':
                $contentExists = $this->postModel->find($id) !== false;
                break;
            case 'user':
                $contentExists = $this->userModel->find($id) !== false;
                break;
        }
        
        if (!$contentExists) {
            $this->json(['success' => false, 'message' => 'Content not found'], 404);
        }
        
        // Check if user has already reported this content
        if ($this->reportModel->hasUserReported($this->getUserId(), $type, $id)) {
            $this->json(['success' => false, 'message' => 'You have already reported this content'], 400);
        }
        
        // Prepare report data based on type
        $reportData = [
            'reporter_id' => $this->getUserId(),
            'reason' => $reason,
            'description' => $description
        ];
        
        // Map the reported content to the correct column
        switch ($type) {
            case 'thread':
                $reportData['thread_id'] = $id;
                break;
            case 'post':
                $reportData['post_id'] = $id;
                break;
            case 'user':
                $reportData['reported_user_id'] = $id;
                break;
        }
        
        // Create report
        $reportId = $this->reportModel->createReport($reportData);
        
        if ($reportId) {
            $this->json(['success' => true, 'message' => 'Report submitted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to submit report'], 500);
        }
    }

    /**
     * Get reports for admin panel
     */
    public function index() {
        $this->requireModerator();
        
        $status = $this->get('status', 'pending');
        $page = max(1, intval($this->get('page', 1)));
        
        $reports = $this->reportModel->getReports($status, $page);
        $counts = $this->reportModel->getReportCounts();
        
        $this->view('admin/reports', [
            'title' => 'Content Reports - ForumHub Pro',
            'reports' => $reports,
            'counts' => $counts,
            'status' => $status,
            'currentPage' => $page
        ]);
    }

    /**
     * Resolve a report
     */
    public function resolve($id) {
        $this->requireModerator();
        
        if ($this->reportModel->resolveReport($id, $this->getUserId())) {
            setFlash('success', 'Report resolved successfully');
        } else {
            setFlash('error', 'Failed to resolve report');
        }
        
        redirect('/admin/reports');
    }

    /**
     * Dismiss a report
     */
    public function dismiss($id) {
        $this->requireModerator();
        
        if ($this->reportModel->dismissReport($id, $this->getUserId())) {
            setFlash('success', 'Report dismissed successfully');
        } else {
            setFlash('error', 'Failed to dismiss report');
        }
        
        redirect('/admin/reports');
    }

    /**
     * View report details
     */
    public function show($id) {
        $this->requireModerator();
        
        $report = $this->reportModel->getReportWithDetails($id);
        
        if (!$report) {
            setFlash('error', 'Report not found');
            redirect('/admin/reports');
        }
        
        // Get the reported content
        $content = null;
        if ($report['thread_id']) {
            $content = $this->threadModel->getThread($report['thread_id']);
            $report['reported_type'] = 'thread';
            $report['reported_id'] = $report['thread_id'];
        } elseif ($report['post_id']) {
            $content = $this->postModel->find($report['post_id']);
            if ($content) {
                $thread = $this->threadModel->find($content['thread_id']);
                $content['thread_title'] = $thread['title'] ?? 'Unknown Thread';
            }
            $report['reported_type'] = 'post';
            $report['reported_id'] = $report['post_id'];
        } elseif ($report['reported_user_id']) {
            $content = $this->userModel->find($report['reported_user_id']);
            $report['reported_type'] = 'user';
            $report['reported_id'] = $report['reported_user_id'];
        }
        
        $this->view('admin/report_details', [
            'title' => 'Report Details - ForumHub Pro',
            'report' => $report,
            'content' => $content
        ]);
    }
}