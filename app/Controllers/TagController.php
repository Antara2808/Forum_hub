<?php

namespace Controllers;

use Core\Controller;
use Models\Tag;
use Models\Thread;

class TagController extends Controller {
    private $tagModel;
    private $threadModel;

    public function __construct() {
        $this->tagModel = new Tag();
        $this->threadModel = new Thread();
    }

    /**
     * Show threads by tag
     */
    public function show($tagId) {
        $tag = $this->tagModel->find($tagId);
        
        if (!$tag) {
            redirect('/threads');
        }
        
        $page = intval($this->get('page', 1));
        $page = $page < 1 ? 1 : $page;
        $perPage = THREADS_PER_PAGE;
        
        $threads = $this->tagModel->getThreadsByTag($tagId, $page, $perPage);
        $totalThreads = count($threads); // In a real app, you'd get the actual count
        $totalPages = ceil($totalThreads / $perPage);
        $totalPages = $totalPages < 1 ? 1 : $totalPages;
        
        // Ensure current page doesn't exceed total pages
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        
        $this->view('threads/index', [
            'title' => 'Threads tagged with ' . $tag['name'] . ' - ForumHub Pro',
            'threads' => $threads,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalThreads' => $totalThreads,
            'tag' => $tag
        ]);
    }

    /**
     * Search tags
     */
    public function search() {
        $query = $this->get('q', '');
        
        if (empty($query)) {
            $this->json(['tags' => []]);
            return;
        }
        
        $tags = $this->tagModel->searchTags($query);
        $this->json(['tags' => $tags]);
    }

    /**
     * Get popular tags
     */
    public function popular() {
        $tags = $this->tagModel->getPopularTags(20);
        $this->json(['tags' => $tags]);
    }
}