<?php

namespace Controllers;

use Core\Controller;
use Models\Thread;
use Models\Category;
use Models\Post;
use Models\User;

class ThreadController extends Controller {
    private $threadModel;
    private $categoryModel;
    private $postModel;
    private $userModel;

    public function __construct() {
        $this->threadModel = new Thread();
        $this->categoryModel = new Category();
        $this->postModel = new \Models\Post();
        $this->userModel = new User();
    }

    /**
     * List all threads
     */
    public function index() {
        $page = intval($this->get('page', 1));
        $page = $page < 1 ? 1 : $page;
        $perPage = THREADS_PER_PAGE;
        $category = $this->get('category');
        
        $categoryData = null;
        if ($category) {
            $categoryData = $this->categoryModel->findBySlug($category);
            if (!$categoryData) {
                redirect('/threads');
            }
            // Get total count for pagination
            $totalThreads = $this->threadModel->count('category_id = ' . $categoryData['id'] . ' AND is_deleted = 0');
            $threads = $this->threadModel->getByCategory($categoryData['id'], $page, $perPage);
        } else {
            // Get total count for pagination
            $totalThreads = $this->threadModel->count('is_deleted = 0');
            $threads = $this->threadModel->getRecentPaginated($page, $perPage);
        }
        
        // Calculate pagination data
        $totalPages = ceil($totalThreads / $perPage);
        $totalPages = $totalPages < 1 ? 1 : $totalPages;
        
        // Ensure current page doesn't exceed total pages
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        
        $categories = $this->categoryModel->getActive();
        
        $this->view('threads/index', [
            'title' => 'Threads - ForumHub Pro',
            'threads' => $threads,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalThreads' => $totalThreads,
            'category' => $category,
            'categoryData' => $categoryData
        ]);
    }

    /**
     * Show single thread
     */
    public function show($id) {
        $thread = $this->threadModel->getThreadWithTags($id);
        
        if (!$thread) {
            redirect('/threads');
        }
        
        // Increment views
        $this->threadModel->incrementViews($id);
        
        // Get posts
        $posts = $this->postModel->getByThread($id);
        
        // Check if user has bookmarked
        $isBookmarked = false;
        if ($this->isLoggedIn()) {
            $isBookmarked = $this->postModel->query(
                "SELECT * FROM bookmarks WHERE user_id = ? AND thread_id = ?",
                [$this->getUserId(), $id]
            );
        }
        
        $this->view('threads/show', [
            'title' => $thread['title'] . ' - ForumHub Pro',
            'thread' => $thread,
            'posts' => $posts,
            'isBookmarked' => !empty($isBookmarked)
        ]);
    }

    /**
     * Show create thread form
     */
    public function create() {
        $this->requireAuth();
        
        $categories = $this->categoryModel->getActive();
        
        $this->view('threads/create', [
            'title' => 'Create Thread - ForumHub Pro',
            'categories' => $categories
        ]);
    }

    /**
     * Store new thread
     */
    public function store() {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/threads/create');
        }
        
        $title = $this->sanitize($this->post('title'));
        $content = $this->post('content');
        $categoryId = $this->post('category_id');
        $tags = $this->post('tags');
        
        if (empty($title) || empty($content) || empty($categoryId)) {
            setFlash('error', 'All fields are required');
            redirect('/threads/create');
        }
        
        $slug = slug($title) . '-' . time();
        
        $threadId = $this->threadModel->create([
            'user_id' => $this->getUserId(),
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'views' => 0
        ]);
        
        if ($threadId) {
            // Add tags if provided
            if (!empty($tags)) {
                $tagArray = array_filter(array_map('trim', explode(',', $tags)));
                if (!empty($tagArray)) {
                    $this->threadModel->addTags($threadId, $tagArray);
                }
            }
            
            // Add reputation
            $this->userModel->addReputation($this->getUserId(), POINTS_CREATE_THREAD);
            
            // Log reputation
            $repLog = new \Models\ReputationLog();
            $repLog->create([
                'user_id' => $this->getUserId(),
                'points' => POINTS_CREATE_THREAD,
                'reason' => 'Created thread: ' . $title,
                'reference_type' => 'thread',
                'reference_id' => $threadId
            ]);
            
            setFlash('success', 'Thread created successfully!');
            redirect('/threads/' . $threadId);
        } else {
            setFlash('error', 'Failed to create thread');
            redirect('/threads/create');
        }
    }

    /**
     * Edit thread
     */
    public function edit($id) {
        $this->requireAuth();
        
        $thread = $this->threadModel->find($id);
        
        if (!$thread || ($thread['user_id'] != $this->getUserId() && !$this->isModerator())) {
            redirect('/threads');
        }
        
        $categories = $this->categoryModel->getActive();
        
        $this->view('threads/edit', [
            'title' => 'Edit Thread - ForumHub Pro',
            'thread' => $thread,
            'categories' => $categories
        ]);
    }

    /**
     * Update thread
     */
    public function update($id) {
        $this->requireAuth();
        
        $thread = $this->threadModel->find($id);
        
        if (!$thread || ($thread['user_id'] != $this->getUserId() && !$this->isModerator())) {
            redirect('/threads');
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/threads/' . $id . '/edit');
        }
        
        $title = $this->sanitize($this->post('title'));
        $content = $this->post('content');
        $categoryId = $this->post('category_id');
        
        if ($this->threadModel->update($id, [
            'title' => $title,
            'content' => $content,
            'category_id' => $categoryId
        ])) {
            setFlash('success', 'Thread updated successfully!');
            redirect('/threads/' . $id);
        } else {
            setFlash('error', 'Failed to update thread');
            redirect('/threads/' . $id . '/edit');
        }
    }

    /**
     * Delete thread
     */
    public function delete($id) {
        $this->requireAuth();
        
        $thread = $this->threadModel->find($id);
        
        if (!$thread || ($thread['user_id'] != $this->getUserId() && !$this->isModerator())) {
            setFlash('error', 'You do not have permission to delete this thread');
            redirect('/threads');
            return;
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/threads/' . $id);
            return;
        }
        
        if ($this->threadModel->update($id, ['is_deleted' => 1])) {
            setFlash('success', 'Thread deleted successfully');
            redirect('/threads');
        } else {
            setFlash('error', 'Failed to delete thread');
            redirect('/threads/' . $id);
        }
    }

    /**
     * Toggle bookmark
     */
    public function toggleBookmark() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $threadId = $this->post('thread_id');
        
        if (!$threadId) {
            $this->json(['success' => false, 'message' => 'Thread ID required'], 400);
            return;
        }
        
        $userId = $this->getUserId();
        
        // Check if already bookmarked
        $existing = $this->threadModel->query(
            "SELECT * FROM bookmarks WHERE user_id = ? AND thread_id = ?",
            [$userId, $threadId]
        );
        
        if (!empty($existing)) {
            // Remove bookmark
            $this->threadModel->query(
                "DELETE FROM bookmarks WHERE user_id = ? AND thread_id = ?",
                [$userId, $threadId]
            );
            $this->json(['success' => true, 'bookmarked' => false, 'message' => 'Bookmark removed']);
        } else {
            // Add bookmark
            $this->threadModel->query(
                "INSERT INTO bookmarks (user_id, thread_id) VALUES (?, ?)",
                [$userId, $threadId]
            );
            $this->json(['success' => true, 'bookmarked' => true, 'message' => 'Thread bookmarked']);
        }
    }

    /**
     * Report thread
     */
    public function report() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $threadId = $this->post('thread_id');
        $reason = $this->post('reason');
        $description = $this->post('description', '');
        
        if (!$threadId || !$reason) {
            $this->json(['success' => false, 'message' => 'Thread ID and reason are required'], 400);
            return;
        }
        
        // Valid reasons
        $validReasons = ['spam', 'abuse', 'inappropriate', 'harassment', 'other'];
        if (!in_array($reason, $validReasons)) {
            $this->json(['success' => false, 'message' => 'Invalid reason'], 400);
            return;
        }
        
        // Check if thread exists
        $thread = $this->threadModel->find($threadId);
        if (!$thread) {
            $this->json(['success' => false, 'message' => 'Thread not found'], 404);
            return;
        }
        
        // Insert report
        $result = $this->threadModel->query(
            "INSERT INTO reports (reporter_id, thread_id, reason, description, status) VALUES (?, ?, ?, ?, 'pending')",
            [$this->getUserId(), $threadId, $reason, $description]
        );
        
        if ($result) {
            $this->json(['success' => true, 'message' => 'Report submitted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to submit report'], 500);
        }
    }
}
