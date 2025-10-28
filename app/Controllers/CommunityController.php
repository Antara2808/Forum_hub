<?php

namespace Controllers;

use Core\Controller;

class CommunityController extends Controller
{
    /**
     * Show community guidelines page
     */
    public function guidelines()
    {
        $data = [
            'title' => 'Community Guidelines - ForumHub Pro'
        ];
        
        $this->view('community/guidelines', $data);
    }
    
    /**
     * Show help center (placeholder for future implementation)
     */
    public function help()
    {
        $data = [
            'title' => 'Help Center - ForumHub Pro'
        ];
        
        // For now, redirect to home or show a placeholder
        redirect('/home');
    }
    
    /**
     * Show contact page (placeholder for future implementation)
     */
    public function contact()
    {
        $data = [
            'title' => 'Contact Us - ForumHub Pro'
        ];
        
        // For now, redirect to home or show a placeholder
        redirect('/home');
    }
}
