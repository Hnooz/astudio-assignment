<?php

use App\Models\Project;
use App\Models\TimeSheet;
use App\Models\User;

beforeEach(function () {
    $this->user = createModel(model: User::class);
});

it('can list all time sheets', function () {
    createModel(model: TimeSheet::class, count: 5, attributes: [
        'user_id' => $this->user->id,
        'project_id' => createModel(model: Project::class)->id,
    ]);

    $this->getJson('/api/v1/time-sheets')->assertSuccessful();

    expect(TimeSheet::count())->toBe(5);
});

it('can get a time sheet', function () {
    $timeSheet = createModel(model: TimeSheet::class, count: 5, attributes: [
        'user_id' => $this->user->id,
        'project_id' => createModel(model: Project::class)->id,
    ]);

    $this->getJson("/api/v1/time-sheets/$timeSheet->id")->assertSuccessful()
        ->assertJson([
            'data' => [
                'id' => $timeSheet->id,
            ],
        ]);
});

it('can create a time sheet', function () {
    $project = createModel(model: Project::class);
    $this->postJson('/api/v1/time-sheets', [
        'project_id' => $project->id,
        'user_id' => $this->user->id,
        'task_name' => 'Task 1',
        'date' => now()->format('Y-m-d'),
        'hours' => 8,
    ])
        ->assertSuccessful()
        ->assertJson([
            'data' => [
                'project_id' => $project->id,
                'date' => now()->format('Y-m-d'),
                'hours' => 8,
            ],
            'message' => 'Time sheet created successfully',
        ]);

    expect(TimeSheet::count())->toBe(1);
});

it('can update a time sheet', function () {
    $project_id = createModel(model: Project::class)->id;
    $timeSheet = createModel(model: TimeSheet::class, attributes: [
        'user_id' => $this->user->id,
        'project_id' => $project_id,
    ]);

    $this->putJson("/api/v1/time-sheets/$timeSheet->id", [
        'task_name' => 'Task 2',
        'date' => now()->format('Y-m-d'),
        'hours' => 4,
        'user_id' => $this->user->id,
        'project_id' => $project_id,
    ])
        ->assertSuccessful();

    expect($timeSheet->fresh()->task_name)->toBe('Task 2');
});

it('can delete a time sheet', function () {
    $timeSheet = createModel(model: TimeSheet::class);
    $this->deleteJson("/api/v1/time-sheets/$timeSheet->id")->assertSuccessful();
    expect(TimeSheet::count())->toBe(0);
});
