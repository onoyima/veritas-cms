<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update specific staff members to have Management Role (5) or Admin Role (1)
        // Staff::ROLE_MGT = 5;
        // User::ROLE_ADMIN = 1;
        
        $emails = [
            'onoyimab@veritas.edu.ng',
            'christopherl@veritas.edu.ng',
            'egbee@veritas.edu.ng',
        ];

        // We use DB facade to avoid model dependency issues during migration
        DB::table('staff')
            ->whereIn('email', $emails)
            ->update(['user_type' => 1]); // Assigning 1 (Super Admin/Admin) directly
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $emails = [
            'onoyimab@veritas.edu.ng',
            'christopherl@veritas.edu.ng',
            'egbee@veritas.edu.ng',
        ];

        // Revert to default staff role (3)
        DB::table('staff')
            ->whereIn('email', $emails)
            ->update(['user_type' => 3]);
    }
};
