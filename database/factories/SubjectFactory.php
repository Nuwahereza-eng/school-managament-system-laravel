<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Ugandan Secondary School Subjects
        $ugandanSubjects = [
            'Mathematics' => 'Study of numbers, quantities, shapes, and patterns. Covers algebra, geometry, trigonometry, and calculus.',
            'English Language' => 'Development of reading, writing, speaking, and listening skills in English communication.',
            'Physics' => 'Study of matter, energy, motion, and force. Includes mechanics, electricity, magnetism, and waves.',
            'Chemistry' => 'Study of substances, their properties, composition, and reactions. Covers organic and inorganic chemistry.',
            'Biology' => 'Study of living organisms, their structure, function, growth, and evolution.',
            'Geography' => 'Study of Earth\'s landscapes, environments, and the relationships between people and their environments.',
            'History' => 'Study of past events, particularly in human affairs, focusing on East African and world history.',
            'Commerce' => 'Study of trade, business operations, and commercial activities in the economy.',
            'Economics' => 'Study of production, distribution, and consumption of goods and services.',
            'Agriculture' => 'Study of farming practices, crop production, animal husbandry, and agricultural economics.',
            'Computer Studies' => 'Introduction to computer hardware, software, programming, and information technology.',
            'Religious Education' => 'Study of religious beliefs, practices, and moral values from various faith traditions.',
            'Fine Art' => 'Development of artistic skills including drawing, painting, sculpture, and design.',
            'Music' => 'Study of musical theory, instruments, vocal techniques, and music appreciation.',
            'Physical Education' => 'Physical fitness, sports, games, and health education for overall well-being.',
            'Luganda' => 'Study of the Luganda language including grammar, literature, and cultural expressions.',
            'Kiswahili' => 'Study of the Kiswahili language, grammar, and East African literature.',
            'French' => 'Introduction to French language, grammar, and francophone culture.',
            'Entrepreneurship' => 'Skills for starting and managing businesses, including business planning and financial literacy.',
            'Technical Drawing' => 'Technical and engineering drawing skills for design and construction.',
        ];

        $subjectName = $this->faker->unique()->randomElement(array_keys($ugandanSubjects));
        
        return [
            'name' => $subjectName,
            'description' => $ugandanSubjects[$subjectName],
            'semester' => rand(0,1),
            'teacher_id' => Teacher::inRandomOrder()->first(),
            'classroom_id' => Classroom::inRandomOrder()->first(),
        ];
    }
}
