<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin', 'description' => 'Administrator dengan akses penuh'],
            ['name' => 'sales', 'display_name' => 'Sales', 'description' => 'Sales untuk menangani transaksi dan approval komisi'],
            ['name' => 'affiliate', 'display_name' => 'Affiliate', 'description' => 'Affiliate untuk merekomendasikan produk'],
            ['name' => 'finance', 'display_name' => 'Finance', 'description' => 'Finance untuk proses pembayaran dan pelaporan'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        // 2. Seed Super Admin User
        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
        
        User::firstOrCreate(
            ['email' => 'admin@affiliate.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 3. Seed Commission Stages
        $superAdminUser = User::where('email', 'admin@affiliate.com')->first();

        $stages = [
            [
                'stage_number' => 1,
                'name' => 'Chat Intent',
                'description' => 'Komisi ketika customer menunjukkan intent order melalui chat',
                'commission_percentage' => 5.00,
                'is_active' => true,
                'created_by' => $superAdminUser->id,
            ],
            [
                'stage_number' => 2,
                'name' => 'DP Paid',
                'description' => 'Komisi ketika customer sudah membayar DP',
                'commission_percentage' => 10.00,
                'is_active' => true,
                'created_by' => $superAdminUser->id,
            ],
            [
                'stage_number' => 3,
                'name' => 'Product Shipped',
                'description' => 'Komisi ketika produk sudah dikirim',
                'commission_percentage' => 15.00,
                'is_active' => true,
                'created_by' => $superAdminUser->id,
            ],
        ];

        foreach ($stages as $stage) {
            \App\Models\CommissionStage::firstOrCreate(
                ['stage_number' => $stage['stage_number']],
                $stage
            );
        }

        $this->command->info('Database seeded successfully!');
    }
}
