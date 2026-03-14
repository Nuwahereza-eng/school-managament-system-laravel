<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // Ugandan first names
    private $ugandanFirstNames = [
        'Aisha', 'Amina', 'Brian', 'Collins', 'David', 'Emmanuel', 'Faith', 'Gerald',
        'Hassan', 'Ivan', 'Joseph', 'Kevin', 'Lydia', 'Moses', 'Nakato', 'Olive',
        'Patrick', 'Rebecca', 'Samuel', 'Timothy', 'Umar', 'Vincent', 'William',
        'Yusuf', 'Zainab', 'Abdul', 'Brenda', 'Charles', 'Diana', 'Edgar',
        'Florence', 'Godfrey', 'Harriet', 'Isaac', 'Juliet', 'Kenneth', 'Lilian',
        'Martin', 'Norah', 'Oscar', 'Priscilla', 'Ronald', 'Sarah', 'Tom', 'Viola'
    ];

    // Ugandan surnames
    private $ugandanSurnames = [
        'Mukasa', 'Ssempijja', 'Namugera', 'Kizza', 'Ochieng', 'Musoke', 'Ssekandi',
        'Namutebi', 'Wasswa', 'Kato', 'Nakamya', 'Lubega', 'Nsubuga', 'Kyambadde',
        'Mugisha', 'Tumwine', 'Byaruhanga', 'Asiimwe', 'Muwanga', 'Ssebufu',
        'Nalwanga', 'Kibuuka', 'Sempala', 'Kakooza', 'Bbosa', 'Katumba', 'Sserunkuuma',
        'Nabukenya', 'Lwanga', 'Okello', 'Adong', 'Apio', 'Amongi', 'Odongo'
    ];

    // Ugandan locations
    private $ugandanLocations = [
        'Kampala', 'Wakiso', 'Entebbe', 'Jinja', 'Mbale', 'Mbarara', 'Gulu',
        'Lira', 'Masaka', 'Kasese', 'Fort Portal', 'Arua', 'Soroti', 'Tororo',
        'Mukono', 'Iganga', 'Kabale', 'Hoima', 'Mityana', 'Luweero'
    ];

    public function definition()
    {
        // Generate Ugandan phone number format: 07XXXXXXXX
        $prefixes = ['70', '71', '72', '74', '75', '76', '77', '78', '79'];
        $prefix = $prefixes[array_rand($prefixes)];
        $phoneNumber = '0' . $prefix . rand(1000000, 9999999);

        return [
            'first_name' => $this->ugandanFirstNames[array_rand($this->ugandanFirstNames)],
            'surname' => $this->ugandanSurnames[array_rand($this->ugandanSurnames)],
            'parent_phone_number' => $phoneNumber,
            'birth_date' => Carbon::now()->subYears(15),
            'classroom_id' => Classroom::inRandomOrder()->first(),
            'address' => $this->ugandanLocations[array_rand($this->ugandanLocations)] . ', Uganda',
            'enrollment_date' => Carbon::now()->subYears(),
            'gender' => rand(0,1),
        ];
    }
}
