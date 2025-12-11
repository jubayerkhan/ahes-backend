<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use App\Models\Role;
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
    $this->call(AdminPermissionTableSeeder::class);
    if (Admin::count() == 0) {
      Admin::withoutEvents(function () {
        $admin = Admin::create([
          'name' => 'Admin',
          'role_id' => Role::where('name', 'admin')->where('type', 'admin')->first()->id ?? 0,
          'email' => 'admin@annanovas.com',
          'email_verified_at' => Carbon::now(),
          'password' => bcrypt('An@123456'),
          'status' => 1,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

        if ($admin->wasRecentlyCreated) {
          $admin->syncRoles([$admin->role_id]);
        }
      });
    }

    $this->call(PermissionTableSeeder::class);
    if (User::count() == 0) {
      User::withoutEvents(function () {
        $admin = User::create([
          'name' => 'Admin',
          'role_id' => Role::where('name', 'admin')->where('type', 'web')->first()->id ?? 0,
          'email' => 'admin@annanovas.com',
          'email_verified_at' => Carbon::now(),
          'password' => bcrypt('An@123456'),
          'status' => 1,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

        if ($admin->wasRecentlyCreated) {
          $admin->syncRoles([$admin->role_id]);
        }
      });
    }
  }
}
