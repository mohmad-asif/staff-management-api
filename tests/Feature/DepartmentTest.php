<?php

namespace Tests\Feature;

use Tests\TestCase;

class DepartmentTest extends TestCase
{

    /**
     * Test creating a department via API.
     */
    // public function testDepartmentCreate(): void
    // {
    //     $payload = [
    //         'title' => 'New Department1',
    //         'department_code' => 'ND1231',
    //     ];        

    //     $response = $this->postJson('/api/departments/store', $payload);

    //     $response->assertStatus(201); // Usually creation returns 201 Created
    //     $response->assertJson([
    //         'title' => 'New Department1',
    //         'department_code' => 'ND1231',
    //     ]);

    //     // Optionally assert database has this new department
    //     $this->assertDatabaseHas('departments', [
    //         'title' => 'New Department1',
    //     ]);
    // }

    /**
     * Test listing all departments via API.
     */
    public function testDepartmentListing(): void
    {
        // Call the API
        $response = $this->get('/api/departments');
dd($response->json());
        $response->assertStatus(200);
        
    }

}
