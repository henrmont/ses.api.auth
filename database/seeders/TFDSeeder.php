<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use App\Models\UserModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TFDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $module = Module::create([
                'name' => 'tfd',
                'url' => 'url do tfd',
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
                'configuração listar',
                'configuração atualizar',
                'datasus listar',
                'datasus criar',
                'datasus atualizar',
                'datasus deletar',
                'datasus importar',
                'unidade hospitalar listar',
                'unidade hospitalar criar',
                'unidade hospitalar atualizar',
                'unidade hospitalar deletar',
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
                'paciente acompanhantes',
                'paciente laudos',
                'solicitação listar',
                'solicitação criar',
                'solicitação atualizar',
                'solicitação deletar',
                'solicitação anexos',
                'parecer listar',
                'parecer criar',
                'parecer atualizar',
                'parecer deletar',
                'parecer anexos',
                'passagem listar',
                'passagem criar',
                'passagem atualizar',
                'passagem deletar',
                'passagem importar',
                'ajuda de custo listar',
                'ajuda de custo criar',
                'ajuda de custo atualizar',
                'ajuda de custo deletar',
                'pagamento listar',
                'pagamento criar',
                'pagamento atualizar',
                'pagamento deletar',
                'consultar paciente',
                'consultar arquivo'
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
