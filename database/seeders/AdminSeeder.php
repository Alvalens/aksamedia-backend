<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'id' => 'b7978b1c-df8c-4d37-b3a6-e8112f6a5ad9',
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '08123456789',
            'email' => 'addmin@admin.com',
            'password' => Hash::make('pastibisa'),
        ]);
    }
}
