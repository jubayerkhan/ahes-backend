<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\AdminSiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SiteSettingController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-site-settings'])) {
      $settings = AdminSiteSetting::pluck('value', 'key')->all();
      $configs = Config::get('constants.ADMIN_SITE_SETTINGS');

      return view('content.admin.setting.site-setting', compact('configs', 'settings'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  public function store(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-site-settings'])) {
      $messages = [
        'settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_LOGO_SETTING_KEY']['NAME'] . '.image' => 'Logo Should be an image.',
        'settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_FAVICON_SETTING_KEY']['NAME'] . '.image' => 'Banner Should be an image.',
      ];
      $this->validate($request, [
        'settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_LOGO_SETTING_KEY']['NAME'] => 'nullable|image',
        'settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_FAVICON_SETTING_KEY']['NAME'] => 'nullable|image',
      ], $messages);

      $settings = $request->get('settings');

      if ($request->hasFile('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_LOGO_SETTING_KEY']['NAME'])) {
        $logoImage = Helpers::uploadFile($request->file('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_LOGO_SETTING_KEY']['NAME']), null, Config::get('constants.SITE_IMAGE_PATH'), null, null);
        $settings[Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_LOGO_SETTING_KEY']['NAME']] = $logoImage;
      }

      if ($request->hasFile('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_FAVICON_SETTING_KEY']['NAME'])) {
        $logoImage = Helpers::uploadFile($request->file('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_FAVICON_SETTING_KEY']['NAME']), null, Config::get('constants.SITE_IMAGE_PATH'), null, null);
        $settings[Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_FAVICON_SETTING_KEY']['NAME']] = $logoImage;
      }

      if (!$request->has('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_GOOGLE_CAPTCHA_ENABLE_SETTING_KEY']['NAME'])) {
      	$settings[Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_GOOGLE_CAPTCHA_ENABLE_SETTING_KEY']['NAME']] = 0;
      }

      // if (!$request->has('settings.' . Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_CAPTCHA_ENTERPRISE_SETTING_KEY']['NAME'])) {
      // 	$settings[Config::get('constants.ADMIN_SITE_SETTINGS')['SITE_CAPTCHA_ENTERPRISE_SETTING_KEY']['NAME']] = 0;
      // }

      foreach ($settings as $key => $value) {
        AdminSiteSetting::updateOrCreate(
          ['key' => $key],
          ['value' => $value]
        );
      }

      Session::flash('success', 'Settings has been Updated');
      return redirect()->route('admin.site-settings.index');
    } else {
      return view('error.admin-unauthorized');
    }
  }
}
