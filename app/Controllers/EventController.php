<?php

namespace Controllers;

use Core\Controller;
use Models\Event;
use Models\User;

class EventController extends Controller {
    private $eventModel;
    private $userModel;

    public function __construct() {
        $this->eventModel = new \Models\Event();
        $this->userModel = new User();
    }

    /**
     * List all events
     */
    public function index() {
        $events = $this->eventModel->getUpcoming();
        
        $this->view('events/index', [
            'title' => 'Events - ForumHub Pro',
            'events' => $events
        ]);
    }

    /**
     * Show single event
     */
    public function show($id) {
        $event = $this->eventModel->getEvent($id);
        
        if (!$event) {
            redirect('/events');
            return;
        }
        
        $participants = $this->eventModel->getParticipants($id);
        
        $this->view('events/show', [
            'title' => $event['title'] . ' - Events',
            'event' => $event,
            'participants' => $participants
        ]);
    }

    /**
     * Create event form
     */
    public function create() {
        $this->requireAuth();
        
        $this->view('events/create', [
            'title' => 'Create Event - ForumHub Pro'
        ]);
    }

    /**
     * Store new event
     */
    public function store() {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/events/create');
            return;
        }
        
        $title = $this->sanitize($this->post('title'));
        $description = $this->post('description');
        $eventDate = $this->post('event_date');
        $location = $this->sanitize($this->post('location'));
        $isOnline = $this->post('is_online') ? 1 : 0;
        
        if (empty($title) || empty($eventDate)) {
            setFlash('error', 'Title and date are required');
            redirect('/events/create');
            return;
        }
        
        $eventId = $this->eventModel->create([
            'user_id' => $this->getUserId(),
            'title' => $title,
            'description' => $description,
            'event_date' => $eventDate,
            'location' => $location,
            'is_online' => $isOnline
        ]);
        
        if ($eventId) {
            setFlash('success', 'Event created successfully!');
            redirect('/events/' . $eventId);
        } else {
            setFlash('error', 'Failed to create event');
            redirect('/events/create');
        }
    }
}
