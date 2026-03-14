<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'surname',
        'student_num',
        'birth_date',
        'address',
        'parent_phone_number',
        'second_phone_number',
        'gender',
        'classroom_id',
        'enrollment_date',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    /**
     * Status constants for better code readability
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_GRADUATED = 'graduated';
    const STATUS_TRANSFERRED = 'transferred';
    const STATUS_SUSPENDED = 'suspended';

    /**
     * Get all available status options
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_GRADUATED => 'Graduated',
            self::STATUS_TRANSFERRED => 'Transferred',
            self::STATUS_SUSPENDED => 'Suspended',
        ];
    }

    /**
     * Get the classroom that the student belongs to.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get the subjects for the student through classroom.
     */
    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            Classroom::class,
            'id',           // Foreign key on classrooms table
            'classroom_id', // Foreign key on subjects table
            'classroom_id', // Local key on students table
            'id'            // Local key on classrooms table
        );
    }

    /**
     * Get the full name of the student.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->surname}";
    }

    /**
     * Scope to filter active students
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to search students by name or student number
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('surname', 'like', "%{$search}%")
              ->orWhere('student_num', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by classroom
     */
    public function scopeInClassroom($query, $classroomId)
    {
        return $query->where('classroom_id', $classroomId);
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
