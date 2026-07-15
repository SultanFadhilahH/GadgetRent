<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        return $admin;
    }

    public function test_admin_can_delete_another_user(): void
    {
        $admin = $this->makeAdmin();
        $target = User::factory()->create();

        $response = $this->actingAs($admin)
            ->delete(route('admin.users.users.destroy', $target));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)
            ->delete(route('admin.users.users.destroy', $admin));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
