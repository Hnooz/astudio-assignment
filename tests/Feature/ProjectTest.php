<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Enums\ProjectStatusEnum;

beforeEach(function () {
    $this->user = createModel(model: User::class);
    $this->project = createModel(model: Project::class, attributes: [
        'name' => 'Project 1',
        'status' => ProjectStatusEnum::ACTIVE,
    ]);
});
it('can get all projects', function () {
    $projects = createModel(model: Project::class, count: 50);
    // attachModel(model: Project::class, relation: 'users', relatedModel: $this->user);
     $this->getJson('/api/v1/projects')->assertSuccessful();

     expect($projects->count())->toBe(51);
});

it('can get a project', function () {
    // attachModel(model: Project::class, relation: 'users', relatedModel: $this->user);
    $this->getJson("/api/v1/projects/{$this->project->id}")->assertSuccessful();

    expect($this->project->name)->toBe('Project 1')->and($this->project->status)->toBe(ProjectStatusEnum::ACTIVE);
});

it('can create a project', function () {
    $this->postJson('/api/v1/projects', [
        'name' => 'Project 2',
        'status' => ProjectStatusEnum::ACTIVE,
        'attributes' => [
            ['id' => createModel(model: Attribute::class)->id, 'value' => 'IT'],
            ['id' => createModel(model: Attribute::class)->id, 'value' => 'Depends on the project'],
        ],
    ])->assertSuccessful()->assertJson([
        'data' => [
            'name' => 'Project 2',
            'status' => ProjectStatusEnum::ACTIVE->value,
        ],
        'message' => 'Project created successfully',
    ]); 

    expect(Project::count())
    ->toBe(2); 

    expect(AttributeValue::count())->toBe(2);

});

it('can update a project', function () {
    $response = $this->putJson("/api/v1/projects/{$this->project->id}", [
        'name' => 'Project 2',
        'status' => ProjectStatusEnum::INACTIVE,
        'attributes' => [
            ['id' => createModel(model: Attribute::class)->id, 'value' => 'IT'],
            ['id' => createModel(model: Attribute::class)->id, 'value' => 'Depends on the project'],
        ],
    ])->assertSuccessful();
    expect($this->project->fresh()->name)->toBe('Project 2')->and($this->project->fresh()->status)->toBe(ProjectStatusEnum::INACTIVE);
    expect($this->project->fresh()->attributeValues()->count())->toBe(2);
});

it('can delete a project', function () {
    $this->deleteJson("/api/v1/projects/{$this->project->id}")->assertSuccessful();
    expect(Project::count())->toBe(0);
});