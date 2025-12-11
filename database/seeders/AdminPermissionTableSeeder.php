<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class AdminPermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    /**
     * Admin Role
     */
    Role::updateOrCreate(
      [
        'name' => 'admin',
        'type' => 'admin',
      ],
      [
        'name' => 'admin',
        'type' => 'admin',
        'display_name' => 'Admin',
        'description' => 'Admin Role can access everything',
        'status' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    /***
     *
     * All Admin Permission
     *
     */

    //Role
    $permissionG = PermissionGroup::updateOrCreate(
      [
        'key' => 'roles',
        'type' => 'admin',
      ],
      [
        'key' => 'roles',
        'type' => 'admin',
        'name' => 'Role Management',
        'status' => 1,
        'priority' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'admin-roles-create',
      ],
      [
        'name' => 'admin-roles-create',
        'display_name' => 'Role Create',
        'description' => 'Role Create',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p2 = Permission::updateOrCreate(
      [
        'name' => 'admin-roles-read',
      ],
      [
        'name' => 'admin-roles-read',
        'display_name' => 'Role Read',
        'description' => 'Role Read',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p3 = Permission::updateOrCreate(
      [
        'name' => 'admin-roles-update',
      ],
      [
        'name' => 'admin-roles-update',
        'display_name' => 'Role Update',
        'description' => 'Role Update',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p4 = Permission::updateOrCreate(
      [
        'name' => 'admin-roles-delete',
      ],
      [
        'name' => 'admin-roles-delete',
        'display_name' => 'Role Delete',
        'description' => 'Role Delete',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $permissionG->permissions()->sync([$p1->id, $p2->id, $p3->id, $p4->id]);

    //Admin
    $adminG = PermissionGroup::updateOrCreate(
      [
        'key' => 'admins',
        'type' => 'admin',
      ],
      [
        'key' => 'admins',
        'type' => 'admin',
        'name' => 'Admin',
        'status' => 1,
        'priority' => 2,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'admin-admins-create',
      ],
      [
        'name' => 'admin-admins-create',
        'display_name' => 'Admin Create',
        'description' => 'Admin Create',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p2 = Permission::updateOrCreate(
      [
        'name' => 'admin-admins-read',
      ],
      [
        'name' => 'admin-admins-read',
        'display_name' => 'Admin Read',
        'description' => 'Admin Read',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p3 = Permission::updateOrCreate(
      [
        'name' => 'admin-admins-update',
      ],
      [
        'name' => 'admin-admins-update',
        'display_name' => 'Admin Update',
        'description' => 'Admin Update',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p4 = Permission::updateOrCreate(
      [
        'name' => 'admin-admins-delete',
      ],
      [
        'name' => 'admin-admins-delete',
        'display_name' => 'Admin Delete',
        'description' => 'Admin Delete',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    $adminG->permissions()->sync([$p1->id, $p2->id, $p3->id, $p4->id]);

    //User
    $userG = PermissionGroup::updateOrCreate(
      [
        'key' => 'users',
        'type' => 'admin',
      ],
      [
        'key' => 'users',
        'type' => 'admin',
        'name' => 'User',
        'status' => 1,
        'priority' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'admin-users-create',
      ],
      [
        'name' => 'admin-users-create',
        'display_name' => 'User Create',
        'description' => 'User Create',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p2 = Permission::updateOrCreate(
      [
        'name' => 'admin-users-read',
      ],
      [
        'name' => 'admin-users-read',
        'display_name' => 'User Read',
        'description' => 'User Read',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p3 = Permission::updateOrCreate(
      [
        'name' => 'admin-users-update',
      ],
      [
        'name' => 'admin-users-update',
        'display_name' => 'User Update',
        'description' => 'User Update',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p4 = Permission::updateOrCreate(
      [
        'name' => 'admin-users-delete',
      ],
      [
        'name' => 'admin-users-delete',
        'display_name' => 'User Delete',
        'description' => 'User Delete',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    $userG->permissions()->sync([$p1->id, $p2->id, $p3->id, $p4->id]);


    //Miscellaneous
    $msG = PermissionGroup::updateOrCreate(
      [
        'key' => 'miscellaneous',
        'type' => 'admin',
      ],
      [
        'key' => 'miscellaneous',
        'type' => 'admin',
        'name' => 'Miscellaneous',
        'status' => 1,
        'priority' => 50,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'admin-site-settings',
      ],
      [
        'name' => 'admin-site-settings',
        'display_name' => 'Site Setting',
        'description' => 'Site Setting',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    $msG->permissions()->sync([$p1->id]);

  }
}
