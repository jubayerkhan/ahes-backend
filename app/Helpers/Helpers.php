<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Helpers
{
  /**
   * this function is used for showing active route
   * @return menu-open
   */
  public static function menuIsOpen($routeNames)
  {
    $currentRoute = Route::currentRouteName();

    if (in_array($currentRoute, $routeNames)) {
      return 'active open';
    }
  }

  /**
   *  this function is used for showing active route
   * @return ACTIVE
   */
  public static function menuIsActive($routeNames)
  {
    $currentRoute = Route::currentRouteName();

    if (in_array($currentRoute, $routeNames)) {
      return 'active';
    }
  }

  /**
   * this function will Upload any file to S3 or local disk
   * pass file or base64sting
   * pass destination folderPath with slash added in last
   * if fileName not provided , ans automatic file name will be generated with segmented folder with year & month
   * @return string Image Name With Segmented Folder
   */

  public static function uploadFile($file = null, $base64string = null, $destinationPath = null, $fileName = null, $disk = null)
  {
    if (!$disk) {
      $disk = env('DISK_TYPE');
    }
    if (!$fileName) {
      if ($file) {
        $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
      } else {
        $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.jpg';
      }
    }

    if ($file) {
      $imagePath = Storage::disk($disk)->putFileAs($destinationPath, $file, $fileName, 'public');

      return $imagePath;
    } elseif ($base64string) {
      $imagePath = Storage::disk($disk)->put($destinationPath . '/' . $fileName, $base64string, 'public');

      return $fileName;
    } else {
      return null;
    }
  }

  //This return the real path of an asset
  public static function storagePath($filePath)
  {
    return env('CDN_URL') . '/' . $filePath;
  }

  /**
   * this function is used for showing the status label
   * @return ACTIVE_STATUSES
   */

public static function activeStatusLabel($activeStatus)
{
    $statuses = Config::get('constants.ACTIVE_STATUSES');

    // Fallback if the key doesn't exist
    if (!array_key_exists($activeStatus, $statuses)) {
        return '<span class="badge bg-label-secondary me-1">Unknown</span>';
    }

    if ($activeStatus == 1) {
        return '<span class="badge bg-label-primary me-1">' . $statuses[$activeStatus] . '</span>';
    } elseif ($activeStatus == 0) {
        return '<span class="badge bg-label-warning me-1">' . $statuses[$activeStatus] . '</span>';
    }
}


  //Send SMS via METRO
  public static function sendSmsViaMetroNet($phones = [], $smsText = null)
  {
    try {
      if (env('METRONET_SMS_API_KEY') && env('METRONET_SMS_SID')) {
        $client = new Client();

        // $response = $client->request('POST', 'http://portal.metrotel.com.bd:8809/smsapi', [
        $response = $client->request('POST', 'http://portal.metrotel.com.bd/smsapi', [
          'timeout' => 5,
          'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
          ],
          'json' => [
            'api_key' => env('METRONET_SMS_API_KEY'),
            'senderid' => env('METRONET_SMS_SID'),
            'type' => 'text',
            'msg' => $smsText,
            'contacts' => implode('+', $phones),
          ],
        ]);

        return ((string) $response->getBody());
      }
    } catch (\Exception $e) {
      return null;
    }
  }


  public static function appClasses()
  {

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'contentLayout' => 'compact',
      'headerType' => 'fixed',
      'navbarType' => 'fixed',
      'menuFixed' => true,
      'menuCollapsed' => false,
      'footerFixed' => false,
      'customizerControls' => [
        'rtl',
        'style',
        'headerType',
        'contentLayout',
        'layoutCollapsed',
        'showDropdownOnHover',
        'layoutNavbarOptions',
        'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'contentLayout' => ['compact', 'wide'],
      'headerType' => ['fixed', 'static'],
      'navbarType' => ['fixed', 'static', 'hidden'],
      'myStyle' => ['light', 'dark', 'system'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'footerFixed' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','ar'=>'ar'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    $styleVal = $data['myStyle'] == "dark" ? "dark" : "light";
    $styleUpdatedVal = $data['myStyle'] == "dark" ? "dark" : $data['myStyle'];
    // Determine if the layout is admin or front based on cookies
    $layoutName = $data['myLayout'];
    $isAdmin = Str::contains($layoutName, 'front') ? false : true;

    $modeCookieName = $isAdmin ? 'admin-mode' : 'front-mode';
    $colorPrefCookieName = $isAdmin ? 'admin-colorPref' : 'front-colorPref';

    // Determine style based on cookies, only if not 'blank-layout'
    if ($layoutName !== 'blank') {
      if (isset($_COOKIE[$modeCookieName])) {
        $styleVal = $_COOKIE[$modeCookieName];
        if ($styleVal === 'system') {
          $styleVal = isset($_COOKIE[$colorPrefCookieName]) ? $_COOKIE[$colorPrefCookieName] : 'light';
          }
        $styleUpdatedVal = $_COOKIE[$modeCookieName];
      }
    }

    isset($_COOKIE['theme']) ? $themeVal = $_COOKIE['theme'] : $themeVal = $data['myTheme'];

    $directionVal = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : $data['myRTLMode'];

    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $themeVal,
      'themeOpt' => $data['myTheme'],
      'style' => $styleVal,
      'styleOpt' => $data['myStyle'],
      'styleOptVal' => $styleUpdatedVal,
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $directionVal,//$data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'contentLayout' => $data['contentLayout'],
      'headerType' => $data['headerType'],
      'navbarType' => $data['navbarType'],
      'menuFixed' => $data['menuFixed'],
      'footerFixed' => $data['footerFixed'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
      $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'fixed') {
      $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
      $layoutClasses['navbarType'] = '';
    } else {
      $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : 'rtl';

    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) && $_COOKIE['direction'] === "true" ? 'rtl' : 'ltr';

    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = true;
    } else {
      $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = true;
    } else {
      $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  //This return site settings
  // public static function getSiteSettings()
  // {
  //   return AdminSiteSetting::pluck('value', 'key')->all();
  // }
}
