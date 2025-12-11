<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use App\Traits\LogsActivityWithVisitor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSiteSetting extends Model
{
  use HasFactory, LogsActivityWithVisitor;
  //Add Log Option
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->logFillable()
      ->logOnlyDirty()
      ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
      ->dontSubmitEmptyLogs();
  }
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'key', 'value',
  ];
}
