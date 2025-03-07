<?php

it('can register a user', function () {
    $response = $this->postJson('/api/v1/register', [
        'first_name' => 'John Doe',
        'last_name' => 'John Doe',
        'email' => 'email@test.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertStatus(200)->dd();

    expect($response->json('message'))->toBe('User registered successfully');
});

it("can't create a new user with invalid data", function () {
    $this->postJson('/api/v1/register', [
        'first_name' => 'John Doe',
        'last_name' => 'John Doe',
    ])->assertStatus(422)->assertJsonValidationErrors(['email', 'password']);
});

it('can login a user', function () {
    $response = $this->postJson('/api/v1/login')->assertStatus(200);

    expect($response->json('message'))->toBe('Login');
});
