<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffTest extends TestCase
{

    // public function test_staff_created(): void
    // {

    //     $response = $this->post('/api/staffs', [
    //         'name' => 'zaheer',
    //         'email' => 'zaheer@example.com',
    //         'phone' => '1234567890',
    //         'designation' => 'Manager',
    //         'joining_date' => '2023-01-01',
    //         'status' => true,
    //         'department_ids' => [1],
    //         'availabilities' => [
    //             ['day' => 'Monday', 'from' => '09:00', 'to' => '17:00'],
    //             ['day' => 'Wednesday', 'from' => '10:00', 'to' => '16:00'],
    //         ],
    //     ]);

    //     $response->assertCreated();
    //     $response->assertStatus(201);
    //     $this->assertDatabaseHas('staff', ['email' => 'zaheer@example.com']);
        
    // }

    // public function test_staff_listing(): void
    // {

    //     $response = $this->get('/api/staffs');

    //     $response->assertStatus(200);
        
    // }

     public function test_staff_show(): void
    {

        $response = $this->get('/api/staffs/12');

        $response->assertStatus(200);

        dd($response->json());
        
    }

    // public function test_staff_can_be_updated(): void
    // {
    //     $staff = Staff::factory()
    //         ->has(Department::factory()->count(1))
    //         ->create([
    //             'email' => 'original@example.com',
    //         ]);

    //     $departments = Department::factory()->count(2)->create();

    //     $response = $this->putJson("/api/staffs/{$staff->id}", [
    //         'name' => 'Updated Name',
    //         'email' => 'updated@example.com',
    //         'department_ids' => $departments->pluck('id')->toArray(),
    //         'availabilities' => [
    //             ['day' => 'Tuesday', 'from' => '08:00', 'to' => '14:00'],
    //         ],
    //     ]);

    //     $response->assertOk();
    //     $this->assertDatabaseHas('staff', ['name' => 'Updated Name']);
    //     $this->assertEquals(2, $staff->fresh()->departments->count());
    //     $this->assertEquals(1, $staff->fresh()->availabilities->count());
    // }

    // public function test_can_show_staff_details(): void
    // {
    //     $staff = Staff::factory()->create();

    //     $response = $this->getJson("/api/staffs/{$staff->id}");

    //     $response->assertOk()
    //         ->assertJsonFragment(['id' => $staff->id]);
    // }

    // public function test_can_list_all_staff(): void
    // {
    //     Staff::factory()->count(5)->create();

    //     $response = $this->getJson('/api/staffs');

    //     $response->assertOk()
    //         ->assertJsonCount(5);
    // }

    // public function test_staff_can_be_deleted(): void
    // {

    //     $response = $this->delete("/api/staffs/4");

    //     $response->assertOk();
    // }
}
