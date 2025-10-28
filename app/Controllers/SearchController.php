<?php

namespace Controllers;

use Core\Controller;
use Models\Thread;
use Models\Category;

class SearchController extends Controller {
    private $threadModel;
    private $categoryModel;

    public function __construct() {
        $this->threadModel = new Thread();
        $this->categoryModel = new Category();
    }

    /**
     * Search page
     */
    public function index() {
        $query = $this->get('q', '');
        $categoryId = $this->get('category');
        $threads = [];
        
        if (!empty($query)) {
            $threads = $this->threadModel->search($query, $categoryId);
        }
        
        $categories = $this->categoryModel->getActive();
        
        $this->view('search/index', [
            'title' => 'Search - ForumHub Pro',
            'query' => $query,
            'threads' => $threads,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }
}
