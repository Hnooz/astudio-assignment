<?php

use App\Models\User;
use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->user = createModel(model: User::class, attributes: [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'user@email.com',
    ]);
});

it('can get all users', function () {
    $users = createModel(model: User::class, count: 50);
    $this->getJson('/api/v1/users')->assertSuccessful();
    
    expect($users->count())->toBe(51);
});

it('can get a user', function () {
    $this->getJson('/api/v1/users/' . $this->user->id)->assertSuccessful();
});

it('can update a user', function () {
    $this->patchJson("/api/v1/users/{$this->user->id}", [
        'first_name' => 'John Doe',
        'last_name' => 'John Doe',
        'email' => 'test@email.com',
    ])->assertSuccessful();

    expect($this->user->fresh()->email)->toBe('test@email.com');
})->skip('add auth system and do it again');

it('can remove a user profile', function () {
    $this->deleteJson("/api/v1/users/{$this->user->id}")->assertSuccessful();

    expect(User::count())->toBe(0);
});