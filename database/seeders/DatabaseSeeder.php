<?php

namespace Database\Seeders;

use App\Models\AgentMunicipal;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $citoyenRole = Role::query()->firstOrCreate(['name' => 'citoyen']);
        $agentRole = Role::query()->firstOrCreate(['name' => 'agent_municipal']);

        User::query()->updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => 'password',
            'role_id' => $adminRole->id,
        ]);

        User::query()->updateOrCreate([
            'email' => 'citoyen@example.com',
        ], [
            'name' => 'Citoyen User',
            'password' => 'password',
            'role_id' => $citoyenRole->id,
        ]);

        $agentUser = User::query()->updateOrCreate([
            'email' => 'agent@example.com',
        ], [
            'name' => 'Agent User',
            'password' => 'password',
            'role_id' => $agentRole->id,
        ]);



        foreach (['Voirie', 'Eclairage', 'Proprete', 'Espaces verts'] as $title) {
            Category::query()->firstOrCreate(['title' => $title]);
        }
    }
}
