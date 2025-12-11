<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Laratrust\Contracts\LaratrustUser;
use App\Traits\LogsActivityWithVisitor;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable implements LaratrustUser
{
  use HasFactory, Notifiable, HasRolesAndPermissions, SoftDeletes, LogsActivityWithVisitor;
  //Add Log Option
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->logFillable()
      ->logOnlyDirty()
      ->dontLogIfAttributesChangedOnly(['admin_id', 'created_at', 'updated_at'])
      ->dontSubmitEmptyLogs();
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'admin_id', 'role_id', 'name', 'email', 'phone', 'password', 'image', 'status',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new AdminResetPasswordNotification($token, $this->email));
  }

  public function role()
  {
    return $this->belongsTo(Role::class)->withTrashed();
  }
}
