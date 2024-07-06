<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all(); // Fetch all users
        $user = $users->random(); // Get a random user
        return [
            'title' => $title = fake()->words(5, true),
            'status' => fake()->randomElement(['completed', 'in-progress', 'stopped', 'planned', 'on hold', 'cancelled']),
            'year' => fake()->randomElement(['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh']),
            'term' => fake()->randomElement(['first', 'second']),
            'deadline' => fake()->dateTimeBetween('2022-01-01', '2026-12-31')->format('Y-m-d'),
            'gitHub_url' => $this->generateGitHubUrl($user->name, $title),
            'documentation' => $title . '.pdf',
            'description' => fake()->paragraph(),
            'user_id' => $user->id,
        ];
    }

    private function generateGitHubUrl($username, $title)
    {
        $title = str_replace(' ', '-', $title);
        $username = str_replace(' ', '-', $username);
        return "https://www.github.com/{$username}/{$title}";
    }
}
