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
        ]);
    }

    /**
     * Verifica e cria os bancos de dados se eles não existirem.
     */
    private function ensureDatabasesExist(): void
    {
        $databases = ['ses.auth', 'ses.core', 'ses.datasus', 'ses.storage', 'ses.tfd'];

        foreach ($databases as $dbName) {
            // Consulta no banco de sistema ('postgres_system') se a base já existe
            $exists = DB::select("SELECT 1 FROM pg_database WHERE datname = ?", [$dbName]);

            if (empty($exists)) {
                // No PostgreSQL, comandos CREATE DATABASE não aceitam Prepared Statements com parâmetros,
                // portanto concatenamos a string usando aspas para suportar nomes com ponto ou caracteres especiais.
                DB::statement("CREATE DATABASE \"{$dbName}\";");
            }
        }
    }
}
