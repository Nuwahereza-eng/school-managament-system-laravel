<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classrooms';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'status',
    ];

    /**
     * Status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

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
     * Get the subjects assigned to this classroom.
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get the students in this classroom.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the teachers teaching in this classroom through subjects.
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subjects', 'classroom_id', 'teacher_id')->distinct();
    }

    /**
     * Get the count of active students in the classroom.
     *
     * @return int
     */
    public function getActiveStudentsCountAttribute(): int
    {
        return $this->students()->where('status', 'active')->count();
    }

    /**
     * Check if classroom has available space
     *
     * @return bool
     */
    public function hasAvailableSpace(): bool
    {
        return $this->students()->count() < $this->capacity;
    }

    /**
     * Get the available seats in the classroom.
     *
     * @return int
     */
    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->capacity - $this->students()->count());
    }

    /**
     * Scope to filter active classrooms
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to search classrooms by name
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
    }
}
