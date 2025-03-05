<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'Inventory Keeper'],
            ['name' => 'Salesman'],
        ]);

        $adminRoleId = DB::table('roles')->where('name', 'Admin')->first()->id;
        $inventoryRoleId = DB::table('roles')->where('name', 'Inventory Keeper')->first()->id;
        $salesmanRoleId = DB::table('roles')->where('name', 'Salesman')->first()->id;

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => hash('sha512','password123'), // Hash password securely
            'role_id' => $adminRoleId,
        ]);

        User::create([
            'name' => 'Inventory Keeper',
            'email' => 'inventory@example.com',
            'password' => hash('sha512','password123'),
            'role_id' => $inventoryRoleId,
        ]);

        User::create([
            'name' => 'Salesman User',
            'email' => 'salesman@example.com',
            'password' => hash('sha512','password123'),
            'role_id' => $salesmanRoleId,
        ]);
    }
}
