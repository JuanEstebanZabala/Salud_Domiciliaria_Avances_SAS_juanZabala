<?php

namespace Database\Seeders;

use App\Models\Section;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class AuthenticationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'Profesional', 'guard_name' => 'web']);
        $role3 = Role::create(['name' => 'Paciente', 'guard_name' => 'web']);

        $user1 = User::create(['document_number' => '123456789', 'name' => 'Admin User', 'email' => 'admin@example.com', 'cell_phone' => '1234567890', 'password' => bcrypt('admin12345'),'profile_id'=>'1', 'location' => 'Bucaramanga'])->assignRole($role1);
        $user2 = User::create(['document_number' => '1098816155', 'name' => 'Profesional', 'email' => 'profesional@example.com', 'cell_phone' => '0987654321', 'password' => bcrypt('admin12345'),'profile_id'=>'2', 'location' => 'Bucaramanga'])->assignRole($role2);
        $user3 = User::create(['document_number' => '1098816166', 'name' => 'Paciente', 'email' => 'paciente@example.com', 'cell_phone' => '6789012345', 'password' => bcrypt('admin12345'),'profile_id'=>'3', 'location' => 'Bucaramanga'])->assignRole($role3);

        //Permission::create(['name' => 'users.view', 'description' => 'Ver usuarios', 'guard_name' => 'api'])->syncRoles([$role1,$role2, $role3]);
        //Permission::create(['name' => 'users.create', 'description' => 'Crear usuarios', 'guard_name' => 'api'])->syncRoles([$role1,$role2, $role3]);
        //Permission::create(['name' => 'users.edit', 'description' => 'Editar usuarios', 'guard_name' => 'api'])->syncRoles([$role1,$role2, $role3]);
        //Permission::create(['name' => 'users.delete', 'description' => 'Eliminar usuarios', 'guard_name' => 'api'])->syncRoles([$role1,$role2, $role3]);
        //Permission::create(['name' => 'users.reset', 'description' => 'Resetear contraseña de usuarios', 'guard_name' => 'api'])->syncRoles([$role1,$role2, $role3]);
    }
}
