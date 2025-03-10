<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\TimeSheet;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory(100)->create()->map(function (Project $project): void {
            $user = User::factory()->create();
            TimeSheet::factory(10)->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);

            $project->users()->attach($user->id);
            AttributeValue::factory()->create([
                'value' => fake()->words(3, true),
                'entity_id' => $project->id,
                'attribute_id' => \App\Models\Attribute::factory(),
            ]);
        });
    }
}
