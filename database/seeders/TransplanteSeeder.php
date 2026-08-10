<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use App\Models\UserModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TransplanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $module = Module::create([
                'name' => 'transplante',
                'url' => 'url do transplante',
            ]);

            $admPermissions = [
                'usuário listar',
                'usuário criar',
                'usuário atualizar',
                'usuário deletar',
                'usuário validar',
                'usuário travar',
                'regra listar',
                'regra criar',
                'regra atualizar',
                'regra deletar',
            ];

            foreach($admPermissions as $vlr) {
                Permission::create([
                    'name'  => $module->name.'/'.$vlr,
                    'guard_name' => 'api',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $role = Role::create([
                'name' => 'admin/'.$module->name,
            ])->syncPermissions(Permission::where('name','LIKE','%'.$module->name.'%')->get());

            $user = User::create([
                'name' => 'Admin '.$module->name,
                'email' => 'admin@'.$module->name.'.com',
                'module_id' => $module->id,
                'is_valid' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ])->assignRole($role);

            $permissions = [
                'voltar',
                'download',
                'paciente listar',
                'paciente criar',
                'paciente atualizar',
                'paciente deletar',
                'paciente validar',
            ];

            foreach($permissions as $vlr) {
                Permission::create([
                    'name'  => $module->name.'/'.$vlr,
                    'guard_name' => 'api',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            UserModule::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'is_editable' => false
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }
    }
}
