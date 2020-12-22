<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin 	= Role::create(['name' => 'superadmin']);
        $roleAdmin 			= Role::create(['name' => 'admin']);
        $roleBuyer 			= Role::create(['name' => 'buyer']);
        $roleSupplier 		= Role::create(['name' => 'supplier']);
        $roleBuying 		= Role::create(['name' => 'buyinghouse']);
        $roleManufacture 	= Role::create(['name' => 'manufacturer']);

        $permissions = [
        	[
                'group_name'=>"dashboard",
                'permissions'=>[
                   "dashboard.view",
                   "dashboard.edit"
                ]
            ],
        	[
                'group_name'=>"category",
                'permissions'=>[
                    "category.add",
                    "category.view",
                    "category.edit",
                    "category.delete",
                ]
            ],
            [
                'group_name'=>"roles",
                'permissions'=>[
                    "role.add",
                    "role.view",
                    "role.edit",
                    "role.delite"
                ]
            ],
            [
                'group_name'=>"adminProfile",
                'permissions'=>[
                    "adminprofile.view",
                    "adminprofile.edit"
                ]
            ],
            [
                'group_name'=>"buyerstatus",
                'permissions'=>[
                    "buyer.view",
                    "buyer.deactive",
                    "buyer.delete"
                ]
            ],
            [
                'group_name'=>"supplierstatus",
                'permissions'=>[
                    "supplier.view",
                    "supplier.deactive",
                    "supplier.delete"
                ]
            ],
        	[
                'group_name'=>"buyinghouseStatus",
                'permissions'=>[
                    "buyinghouse.view",
                    "buyinghouse.deactive",
                    "buyinghouse.delete"
                ]
            ],
            [
                'group_name'=>"manufacturerStatus",
                'permissions'=>[
                    "manufacturer.view",
                    "manufacturer.deactive",
                    "manufacturer.delete"
                ]
            ]
        	
        ];
        for ($i=0; $i <count($permissions) ; $i++) { 
            $permissionsGroup = $permissions[$i]["group_name"];

            for ($j=0; $j < count($permissions[$i]["permissions"]); $j++) { 
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j],'group_name'=>$permissionsGroup]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        	
        }
    }
}
