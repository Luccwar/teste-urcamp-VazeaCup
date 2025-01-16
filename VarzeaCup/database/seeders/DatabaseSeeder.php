<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Cria 10 usuários aleatórios

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com', //Email deve ser válido
            'password' => bcrypt('admin1'), //Senha deve possuir 6 caracteres ou mais
        ]);
    }
}
