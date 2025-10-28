<?php

namespace Controllers;

use Core\Controller;
use Models\User;
use Models\Thread;
use Models\Post;
use Models\Friend;

class ProfileController extends Controller {
    private $userModel;
    private $threadModel;
    private $postModel;
    private $friendModel;

    public function __construct() {
        $this->userModel = new User();
        $this->threadModel = new Thread();
        $this->postModel = new Post();
        $this->friendModel = new Friend();
    }

    /**
     * Show user profile
     */
    public function show($id) {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            redirect('/home');
            return;
        }
        
        // Get user stats
        $stats = $this->userModel->getStats($id);
        
        // Get user threads
        $threads = $this->threadModel->getByUser($id);
        
        // Get user posts
        $posts = $this->postModel->getByUser($id, 10);
        
        // Get reputation rank
        $rank = getReputationRank($user['reputation']);
        
        // Get friend data
        $friends = $this->friendModel->getFriends($id);
        $friendCount = $this->friendModel->countFriends($id);
        $friendStatus = null;
        
        if ($this->isLoggedIn() && $this->getUserId() != $id) {
            $friendStatus = $this->friendModel->getFriendStatus($this->getUserId(), $id);
        }
        
        $this->view('profile/show', [
            'title' => $user['username'] . ' - Profile',
            'user' => $user,
            'stats' => $stats,
            'threads' => $threads,
            'posts' => $posts,
            'rank' => $rank,
            'friends' => $friends,
            'friendCount' => $friendCount,
            'friendStatus' => $friendStatus
        ]);
    }

    /**
     * Edit profile form
     */
    public function edit($id) {
        $this->requireAuth();
        
        // Users can only edit their own profile unless admin
        if ($id != $this->getUserId() && !$this->isAdmin()) {
            setFlash('error', 'You can only edit your own profile');
            redirect('/profile/' . $id);
            return;
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            redirect('/home');
            return;
        }
        
        $this->view('profile/edit', [
            'title' => 'Edit Profile',
            'user' => $user
        ]);
    }

    /**
     * Update profile
     */
    public function update($id) {
        $this->requireAuth();
        
        // Users can only edit their own profile unless admin
        if ($id != $this->getUserId() && !$this->isAdmin()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/profile/' . $id . '/edit');
            return;
        }
        
        $data = [
            'bio' => $this->sanitize($this->post('bio')),
            'location' => $this->sanitize($this->post('location')),
            'website' => $this->sanitize($this->post('website')),
            'twitter' => $this->sanitize($this->post('twitter')),
            'github' => $this->sanitize($this->post('github')),
            'linkedin' => $this->sanitize($this->post('linkedin')),
            'instagram' => $this->sanitize($this->post('instagram')),
            'profile_theme' => $this->sanitize($this->post('profile_theme')),
            'banner_style' => $this->sanitize($this->post('banner_style')),
            'show_email' => $this->post('show_email') ? 1 : 0,
            'show_online' => $this->post('show_online') ? 1 : 0,
            'profile_visibility' => $this->sanitize($this->post('profile_visibility'))
        ];
        
        // Handle avatar upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $allowed = ALLOWED_IMAGE_TYPES;
            $filename = $_FILES['avatar']['name'];
            $filesize = $_FILES['avatar']['size'];
            
            if ($filesize > MAX_FILE_SIZE) {
                setFlash('error', 'Avatar file too large (max 5MB)');
                redirect('/profile/' . $id . '/edit');
                return;
            }
            
            if (isAllowedFileType($filename, $allowed)) {
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $newFilename = 'avatar_' . $id . '_' . time() . '.' . $ext;
                $uploadPath = UPLOAD_PATH . '/avatars/' . $newFilename;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
                    $data['avatar'] = $newFilename;
                }
            } else {
                setFlash('error', 'Invalid file type for avatar');
                redirect('/profile/' . $id . '/edit');
                return;
            }
        }
        
        // Handle banner upload
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === 0) {
            $allowed = ALLOWED_IMAGE_TYPES;
            $filename = $_FILES['banner']['name'];
            $filesize = $_FILES['banner']['size'];
            
            if ($filesize > MAX_FILE_SIZE) {
                setFlash('error', 'Banner file too large (max 5MB)');
                redirect('/profile/' . $id . '/edit');
                return;
            }
            
            if (isAllowedFileType($filename, $allowed)) {
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $newFilename = 'banner_' . $id . '_' . time() . '.' . $ext;
                $uploadPath = UPLOAD_PATH . '/banners/' . $newFilename;
                
                if (move_uploaded_file($_FILES['banner']['tmp_name'], $uploadPath)) {
                    $data['banner'] = $newFilename;
                }
            }
        }
        
        // Update theme if changed
        if ($this->post('theme')) {
            $data['theme'] = $this->post('theme');
            $_SESSION['user']['theme'] = $this->post('theme');
        }
        
        if ($this->userModel->updateUser($id, $data)) {
            setFlash('success', 'Profile updated successfully!');
        } else {
            setFlash('error', 'Failed to update profile');
        }
        
        redirect('/profile/' . $id);
    }
    
    /**
     * Remove avatar
     */
    public function removeAvatar($id) {
        $this->requireAuth();
        
        if ($id != $this->getUserId()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }
        
        $user = $this->userModel->find($id);
        
        // Delete old avatar file if exists
        if ($user['avatar']) {
            $oldFile = UPLOAD_PATH . '/avatars/' . $user['avatar'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        
        // Update database to set avatar to null
        if ($this->userModel->updateUser($id, ['avatar' => null])) {
            // Update session
            $_SESSION['user']['avatar'] = null;
            $this->json(['success' => true, 'message' => 'Avatar removed successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to remove avatar'], 500);
        }
    }
    
    /**
     * Remove banner
     */
    public function removeBanner($id) {
        $this->requireAuth();
        
        if ($id != $this->getUserId()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }
        
        $user = $this->userModel->find($id);
        
        // Delete old banner file if exists
        if ($user['banner']) {
            $oldFile = UPLOAD_PATH . '/banners/' . $user['banner'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        
        // Update database to set banner to null
        if ($this->userModel->updateUser($id, ['banner' => null])) {
            $this->json(['success' => true, 'message' => 'Banner removed successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to remove banner'], 500);
        }
    }
}
