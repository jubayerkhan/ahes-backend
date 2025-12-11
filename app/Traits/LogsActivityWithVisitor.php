<?php

namespace App\Traits;


use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityWithVisitor
{
  use LogsActivity;

  public function tapActivity(Activity $activity, string $eventName)
  {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
      $activity->log_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    } else {
      $activity->log_ip = request()->ip();
    }

    if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
      $activity->log_ip_country = $_SERVER["HTTP_CF_IPCOUNTRY"];
    }

    $activity->log_user_agent = request()->userAgent();
  }
}
