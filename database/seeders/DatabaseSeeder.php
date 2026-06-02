<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Superadmin Account (Global Platform Owner)
        User::create([
            'name'      => 'System Administrator',
            'email'     => 'superadmin@laradms.com',
            'password'  => Hash::make('Password123!'),
            'role'      => 'superadmin',
            'tenant_id' => null, // Superadmin does not belong to any tenant
        ]);

        // Sample Tenant (Demo Company)
        $tenant = Tenant::create([
            'name'          => 'Acme Corporation',
            'email'         => 'contact@acmecorp.com',
            'domain_prefix' => 'acme-corp',
            'status'        => 'active',
            'address'       => '123 Business Avenue, Tech District, New York, NY 10001',
        ]);

        // Tenant Admin Account (Owner of Acme Corporation)
        User::create([
            'name'      => 'Acme Admin',
            'email'     => 'admin@acmecorp.com',
            'password'  => Hash::make('Password123!'),
            'role'      => 'tenant_admin',
            'tenant_id' => $tenant->id,
        ]);
    }
}
