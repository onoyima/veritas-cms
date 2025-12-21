<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Roles Table
        if (!Schema::hasTable('website_roles')) {
            Schema::create('website_roles', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g., "Super Admin"
                $table->string('slug')->unique(); // e.g., "super-admin"
                $table->timestamps();
            });
        }

        // 2. Permissions Table
        if (!Schema::hasTable('website_permissions')) {
            Schema::create('website_permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g., "Edit Pages"
                $table->string('slug')->unique(); // e.g., "edit-pages"
                $table->timestamps();
            });
        }

        // 3. Role-Permission Pivot
        if (!Schema::hasTable('website_role_permissions')) {
            Schema::create('website_role_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained('website_roles')->onDelete('cascade');
                $table->foreignId('permission_id')->constrained('website_permissions')->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['role_id', 'permission_id']);
            });
        }

        // 4. Staff-Role Pivot (Connecting existing Staff table to Website Roles)
        if (!Schema::hasTable('website_staff_roles')) {
            Schema::create('website_staff_roles', function (Blueprint $table) {
                $table->id();
                // Reference the existing 'staff' table.
                // The 'staff' table uses 'int(10) unsigned' for 'id'.
                // We must use 'unsignedInteger' to match it, not 'foreignId' (which is BigInt).
                $table->unsignedInteger('staff_id');
                $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
                
                $table->foreignId('role_id')->constrained('website_roles')->onDelete('cascade');
                $table->timestamps();

                $table->unique(['staff_id', 'role_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_staff_roles');
        Schema::dropIfExists('website_role_permissions');
        Schema::dropIfExists('website_permissions');
        Schema::dropIfExists('website_roles');
    }
};
