<?php

namespace Tests\Feature;

use App\Models\Practitioner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PractitionerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_practitioner_directory(): void
    {
        $this->get(route('practitioners.index'))
            ->assertRedirect(route('login'));
    }

    public function test_public_account_registration_is_disabled_for_the_single_admin_app(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_authenticated_admin_can_view_the_practitioner_directory(): void
    {
        $this->actingAs(User::factory()->create());
        Practitioner::factory()->create(['name' => 'Jordan Avery']);

        $this->get(route('practitioners.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('practitioners/Index')
                ->has('practitioners', 1)
                ->where('practitioners.0.name', 'Jordan Avery'));
    }

    public function test_database_seeder_creates_one_admin_and_six_practitioners(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email' => 'admin@clinicmetrics.test']);
        $this->assertDatabaseCount('practitioners', 6);
        $this->assertDatabaseCount('appointments', 80);
    }
}
