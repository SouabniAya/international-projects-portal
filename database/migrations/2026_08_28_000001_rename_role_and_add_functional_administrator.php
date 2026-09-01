<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('Role')->where('roleName', 'International Relations Officer')->exists()) {
            DB::table('Role')
                ->where('roleName', 'International Relations Officer')
                ->update(['roleName' => 'Super Administrator']);
        }

        if (!DB::table('Role')->where('roleName', 'Super Administrator')->exists()) {
            DB::table('Role')->insert(['roleName' => 'Super Administrator']);
        }

        if (!DB::table('Role')->where('roleName', 'Functional Administrator')->exists()) {
            DB::table('Role')->insert(['roleName' => 'Functional Administrator']);
        }
    }

    public function down(): void
    {
        if (DB::table('Role')->where('roleName', 'Super Administrator')->exists()) {
            DB::table('Role')
                ->where('roleName', 'Super Administrator')
                ->update(['roleName' => 'International Relations Officer']);
        }

        DB::table('Role')->where('roleName', 'Functional Administrator')->delete();
    }
};
