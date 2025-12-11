<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\LogOptions;
use Laratrust\Contracts\LaratrustUser;
use App\Traits\LogsActivityWithVisitor;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements LaratrustUser
{
  use HasFactory, Notifiable, HasRolesAndPermissions, SoftDeletes, LogsActivityWithVisitor;
  //Add Log Option
  public function getActivitylogOptions(): LogOptions
  {
      return LogOptions::defaults()
          ->logFillable()
          ->logOnlyDirty()
          ->dontLogIfAttributesChangedOnly(['admin_id', 'user_id', 'created_at', 'updated_at'])
          ->dontSubmitEmptyLogs();
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'admin_id', 'user_id', 'role_id', 'name', 'email', 'phone', 'password', 'image', 'status',
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
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new UserResetPasswordNotification($token, $this->email));
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }
}
