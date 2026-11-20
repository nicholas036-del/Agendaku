<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_ditolak(): void
    {
        $this->getJson('/api/calendar/month?month=2026-11')->assertUnauthorized();
    }

    public function test_user_login_mendapat_json_agenda(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/calendar/month?month=2026-11')
            ->assertOk()
            ->assertJsonStructure(['month', 'agenda']);
    }
}