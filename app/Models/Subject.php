<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'semester',
        'subject_code',
        'teacher_id',
        'classroom_id',
        'credits',
        'status',
    ];

    /**
     * Status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Semester constants
     */
    const SEMESTER_FIRST = 1;
    const SEMESTER_SECOND = 2;

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
        ];
    }

    /**
     * Get all available semester options
     *
     * @return array
     */
    public static function getSemesterOptions(): array
    {
        return [
            self::SEMESTER_FIRST => 'First Semester',
            self::SEMESTER_SECOND => 'Second Semester',
        ];
    }

    /**
     * Get the classroom that this subject is assigned to.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get the teacher who teaches this subject.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the students studying this subject through classroom.
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Classroom::class,
            'id',           // Foreign key on classrooms table
            'classroom_id', // Foreign key on students table
            'classroom_id', // Local key on subjects table
            'id'            // Local key on classrooms table
        );
    }

    /**
     * Scope to filter active subjects
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to search subjects by name or code
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('subject_code', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by semester
     */
    public function scopeInSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope to filter by teacher
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Scope to filter by classroom
     */
    public function scopeInClassroom($query, $classroomId)
    {
        return $query->where('classroom_id', $classroomId);
    }
}
