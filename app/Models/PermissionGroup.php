<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionGroup extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'name', 'key', 'type', 'priority', 'status',
  ];

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'permission_group_permission', 'permission_group_id', 'permission_id');
  }
}
