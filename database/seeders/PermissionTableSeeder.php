<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class PermissionTableSeeder extends Seeder
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
        'type' => 'web',
      ],
      [
        'name' => 'admin',
        'type' => 'web',
        'display_name' => 'Admin',
        'description' => 'Admin Role can access everything',
        'status' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    /***
     *
     * All User Permission
     *
     */

    //Role
    $permissionG = PermissionGroup::updateOrCreate(
      [
        'key' => 'roles',
        'type' => 'web',
      ],
      [
        'key' => 'roles',
        'type' => 'web',
        'name' => 'Role Management',
        'status' => 1,
        'priority' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'user-roles-create',
      ],
      [
        'name' => 'user-roles-create',
        'display_name' => 'Role Create',
        'description' => 'Role Create',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p2 = Permission::updateOrCreate(
      [
        'name' => 'user-roles-read',
      ],
      [
        'name' => 'user-roles-read',
        'display_name' => 'Role Read',
        'description' => 'Role Read',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p3 = Permission::updateOrCreate(
      [
        'name' => 'user-roles-update',
      ],
      [
        'name' => 'user-roles-update',
        'display_name' => 'Role Update',
        'description' => 'Role Update',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p4 = Permission::updateOrCreate(
      [
        'name' => 'user-roles-delete',
      ],
      [
        'name' => 'user-roles-delete',
        'display_name' => 'Role Delete',
        'description' => 'Role Delete',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $permissionG->permissions()->sync([$p1->id, $p2->id, $p3->id, $p4->id]);

    //User
    $userG = PermissionGroup::updateOrCreate(
      [
        'key' => 'users',
        'type' => 'web',
      ],
      [
        'key' => 'users',
        'type' => 'web',
        'name' => 'User',
        'status' => 1,
        'priority' => 2,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'user-users-create',
      ],
      [
        'name' => 'user-users-create',
        'display_name' => 'User Create',
        'description' => 'User Create',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p2 = Permission::updateOrCreate(
      [
        'name' => 'user-users-read',
      ],
      [
        'name' => 'user-users-read',
        'display_name' => 'User Read',
        'description' => 'User Read',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p3 = Permission::updateOrCreate(
      [
        'name' => 'user-users-update',
      ],
      [
        'name' => 'user-users-update',
        'display_name' => 'User Update',
        'description' => 'User Update',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p4 = Permission::updateOrCreate(
      [
        'name' => 'user-users-delete',
      ],
      [
        'name' => 'user-users-delete',
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
        'type' => 'web',
      ],
      [
        'key' => 'miscellaneous',
        'type' => 'web',
        'name' => 'Miscellaneous',
        'status' => 1,
        'priority' => 50,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );
    $p1 = Permission::updateOrCreate(
      [
        'name' => 'user-site-settings',
      ],
      [
        'name' => 'user-site-settings',
        'display_name' => 'Site Setting',
        'description' => 'Site Setting',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
    );

    $msG->permissions()->sync([$p1->id]);
  }
}
