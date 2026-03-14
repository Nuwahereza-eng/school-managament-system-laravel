<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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

    public function definition()
    {
        $firstName = $this->ugandanFirstNames[array_rand($this->ugandanFirstNames)];
        $surname = $this->ugandanSurnames[array_rand($this->ugandanSurnames)];
        
        return [
            'name' => $firstName . ' ' . $surname,
            'email' => strtolower($firstName . '.' . $surname) . rand(1, 999) . '@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
