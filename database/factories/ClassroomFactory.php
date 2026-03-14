<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // Ugandan classroom naming convention
    private $classNames = [
        'Primary 1', 'Primary 2', 'Primary 3', 'Primary 4', 'Primary 5', 'Primary 6', 'Primary 7',
        'Senior 1', 'Senior 2', 'Senior 3', 'Senior 4', 'Senior 5', 'Senior 6'
    ];

    private $sections = ['A', 'B', 'C', 'East', 'West', 'North', 'South'];

    private static $usedNames = [];

    public function definition()
    {
        // Generate unique classroom name
        do {
            $className = $this->classNames[array_rand($this->classNames)];
            $section = $this->sections[array_rand($this->sections)];
            $fullName = $className . ' ' . $section;
        } while (in_array($fullName, self::$usedNames));
        
        self::$usedNames[] = $fullName;

        return [
            'name' => $fullName,
            'description' => 'Class for ' . $className . ' students, Section ' . $section,
        ];
    }
}
