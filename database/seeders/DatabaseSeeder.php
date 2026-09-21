<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Garante que os bancos de dados existem no PostgreSQL local
        $this->ensureDatabasesExist();

        $this->call([
            TFDSeeder::class,
            DATASUSSeeder::class,
            SISLICSeeder::class,
        ]);
    }

    /**
     * Verifica e cria os bancos de dados se eles não existirem.
     */
    private function ensureDatabasesExist(): void
    {
        $databases = ['ses.auth', 'ses.core', 'ses.storage'];

        foreach ($databases as $dbName) {
            $exists = DB::select("SELECT 1 FROM pg_database WHERE datname = ?", [$dbName]);

            if (empty($exists)) {
                DB::statement("CREATE DATABASE \"{$dbName}\";");
            }
        }
    }
}
