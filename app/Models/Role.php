<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Laratrust\Models\Role as RoleModel;
use App\Traits\LogsActivityWithVisitor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends RoleModel
{
  use SoftDeletes, LogsActivityWithVisitor;
  //Add Log Option
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()
          ->logFillable()
          ->logOnlyDirty()
          ->dontLogIfAttributesChangedOnly(['action_id', 'created_at', 'updated_at'])
          ->dontSubmitEmptyLogs();
  }
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'action_id', 'name', 'type', 'display_name', 'description', 'status',
  ];

  public function users()
  {
    return $this->hasMany(User::class, 'role_id');
  }
}
