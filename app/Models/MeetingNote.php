<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingNote extends Model
{
    protected $fillable = [
        'parent_id',
        'document_no',
        'project_name',
        'meeting_date',
        'meeting_time',
        'meeting_location',
        'type_of_meeting',
        'meeting_called_by',
        'attendance',
        'note_taker',
        'topic',
        'meeting_result',
        'on_progress',
        'akan_dilakukan',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    /**
     * Generate next document number
     */
    public static function generateDocumentNo()
    {
        $lastDocument = self::orderBy('document_no', 'desc')->first();
        
        if (!$lastDocument) {
            return '0001';
        }
        
        $lastNo = intval($lastDocument->document_no);
        return str_pad($lastNo + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get formatted meeting date
     */
    public function getFormattedDateAttribute()
    {
        return $this->meeting_date->format('d F Y');
    }

    /**
     * Get attendance as array
     */
    public function getAttendanceArrayAttribute()
    {
        return explode(', ', $this->attendance);
    }
}
