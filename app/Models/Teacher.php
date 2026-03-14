<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'surname',
        'teacher_num',
        'birth_date',
        'email',
        'phone_number',
        'photo_path',
        'address',
        'gender',
        'status',
        'hire_date',
        'qualification',
        'specialization',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
    ];

    /**
     * Status constants for better code readability
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ON_LEAVE = 'on_leave';
    const STATUS_TERMINATED = 'terminated';

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
            self::STATUS_ON_LEAVE => 'On Leave',
            self::STATUS_TERMINATED => 'Terminated',
        ];
    }

    /**
     * Get the subjects taught by this teacher.
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get the classrooms this teacher teaches in.
     */
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'subjects', 'teacher_id', 'classroom_id')->distinct();
    }

    /**
     * Get the full name of the teacher.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->surname}";
    }

    /**
     * Scope to filter active teachers
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to search teachers by name, email or teacher number
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('surname', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('teacher_num', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by specialization
     */
    public function scopeWithSpecialization($query, $specialization)
    {
        return $query->where('specialization', 'like', "%{$specialization}%");
    }
}
