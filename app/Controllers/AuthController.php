<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function login() {
        if ($this->isLoggedIn()) {
            redirect('/home');
        }

        $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    /**
     * Handle login
     */
    public function loginPost() {
        if ($this->isLoggedIn()) {
            redirect('/home');
        }

        // Validate CSRF token
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request. Please try again.');
            redirect('/auth/login');
        }

        $email = $this->sanitize($this->post('email'));
        $password = $this->post('password');
        $remember = $this->post('remember');

        // Validation
        if (empty($email) || empty($password)) {
            setFlash('error', 'Please fill all fields');
            redirect('/auth/login');
        }

        // Find user
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            setFlash('error', 'Invalid credentials');
            redirect('/auth/login');
        }

        // Check if banned
        if ($user['is_banned']) {
            setFlash('error', 'Your account has been banned. Reason: ' . $user['ban_reason']);
            redirect('/auth/login');
        }

        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            setFlash('error', 'Invalid credentials');
            redirect('/auth/login');
        }

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'avatar' => $user['avatar'],
            'reputation' => $user['reputation'] ?? 0,
            'theme' => $user['theme'] ?? 'dark'
        ];

        // Update last seen
        $this->userModel->updateLastSeen($user['id']);

        setFlash('success', 'Welcome back, ' . $user['username'] . '!');
        redirect('/home');
    }

    /**
     * Show register form
     */
    public function register() {
        if ($this->isLoggedIn()) {
            redirect('/home');
        }

        $this->view('auth/register', [
            'title' => 'Register'
        ]);
    }

    /**
     * Handle registration
     */
    public function registerPost() {
        if ($this->isLoggedIn()) {
            redirect('/home');
        }

        // Validate CSRF token
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request. Please try again.');
            redirect('/auth/register');
        }

        $username = $this->sanitize($this->post('username'));
        $email = $this->sanitize($this->post('email'));
        $password = $this->post('password');
        $confirmPassword = $this->post('password_confirm');
        $role = $this->sanitize($this->post('role'));

        // Validation
        $errors = [];

        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }

        if (empty($email) || !$this->validateEmail($email)) {
            $errors[] = 'Valid email is required';
        }

        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
        
        // Validate role
        if (!in_array($role, ['user', 'moderator'])) {
            $role = 'user';
        }

        // Check if username exists
        if ($this->userModel->findByUsername($username)) {
            $errors[] = 'Username already taken';
        }

        // Check if email exists
        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'Email already registered';
        }

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/auth/register');
        }

        // Create user
        $userId = $this->userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'reputation' => 0
        ]);

        if ($userId) {
            setFlash('success', 'Account created successfully! Please login.');
            redirect('/auth/login');
        } else {
            setFlash('error', 'Registration failed. Please try again.');
            redirect('/auth/register');
        }
    }

    /**
     * Logout
     */
    public function logout() {
        if ($this->isLoggedIn()) {
            // Update user status
            $this->userModel->update($this->getUserId(), ['is_online' => 0]);
        }

        // Destroy session
        session_destroy();
        setFlash('success', 'You have been logged out.');
        redirect('/auth/login');
    }
}
