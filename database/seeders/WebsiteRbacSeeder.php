<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteRole;
use App\Models\WebsitePermission;
use App\Models\Staff;

class WebsiteRbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles
        $superAdmin = WebsiteRole::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin']
        );

        $facultyAdmin = WebsiteRole::firstOrCreate(
            ['slug' => 'faculty-admin'],
            ['name' => 'Faculty Admin']
        );

        $editor = WebsiteRole::firstOrCreate(
            ['slug' => 'editor'],
            ['name' => 'Editor']
        );

        // 2. Create Permissions
        $permissions = [
            'access-cms' => 'Access CMS Dashboard',
            'manage-pages' => 'Create, Edit, Delete Pages',
            'manage-blocks' => 'Manage Content Blocks',
            'publish-content' => 'Publish Content',
            'manage-users' => 'Manage CMS Users & Roles',
        ];

        foreach ($permissions as $slug => $name) {
            $perm = WebsitePermission::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );

            // Assign all permissions to Super Admin
            if (!$superAdmin->permissions()->where('permission_id', $perm->id)->exists()) {
                $superAdmin->permissions()->attach($perm->id);
            }
        }

        // 3. Assign Super Admin Role to Specific Staff
        $staffEmails = [
            'onoyimab@veritas.edu.ng',
            'christopherl@veritas.edu.ng',
            'egbee@veritas.edu.ng',
        ];

        foreach ($staffEmails as $email) {
            $staff = Staff::where('email', $email)->first();
            if ($staff) {
                if (!$staff->websiteRoles()->where('role_id', $superAdmin->id)->exists()) {
                    $staff->websiteRoles()->attach($superAdmin->id);
                    $this->command->info("Assigned Super Admin role to: {$email}");
                } else {
                    $this->command->info("Staff {$email} already has Super Admin role.");
                }
            } else {
                $this->command->warn("Staff with email {$email} not found.");
            }
        }
    }
}
