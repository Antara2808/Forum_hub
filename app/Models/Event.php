<?php

namespace Models;

use Core\Model;

class Event extends Model {
    protected $table = 'events';

    /**
     * Create event
     */
    public function create($data) {
        return $this->insert($data);
    }

    /**
     * Get upcoming events
     */
    public function getUpcoming() {
        $sql = "SELECT e.*, u.username, u.avatar,
                (SELECT COUNT(*) FROM event_participants WHERE event_id = e.id AND status = 'going') as participant_count
                FROM events e
                JOIN users u ON e.user_id = u.id
                WHERE e.event_date >= NOW() AND e.is_cancelled = 0
                ORDER BY e.event_date ASC";
        
        return $this->query($sql);
    }

    /**
     * Get event details
     */
    public function getEvent($id) {
        $sql = "SELECT e.*, u.username, u.avatar,
                (SELECT COUNT(*) FROM event_participants WHERE event_id = e.id AND status = 'going') as participant_count
                FROM events e
                JOIN users u ON e.user_id = u.id
                WHERE e.id = ?";
        
        return $this->queryFirst($sql, [$id]);
    }

    /**
     * Get event participants
     */
    public function getParticipants($eventId) {
        $sql = "SELECT ep.*, u.username, u.avatar, u.reputation
                FROM event_participants ep
                JOIN users u ON ep.user_id = u.id
                WHERE ep.event_id = ?
                ORDER BY ep.created_at ASC";
        
        return $this->query($sql, [$eventId]);
    }
}
