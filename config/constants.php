<?php

/**
 * Created by Kobir Hossain.
 * User: kobir
 * Date: 25/07/2023
 */
return [
  'ACTIVE_STATUSES' => [1 => 'Active', 0 => 'Inactive'],
  'USER_IMAGES' => 'userImages',

  'CAUSER_TYPES_DROPDOWN' => [
    'admin' => 'From Admin',
    'user' => 'From User',
  ],
  'CAUSER_TYPES' => [
    'admin' => 'App\Models\Admin',
    'user' => 'App\Models\User',
  ],
  'EVENTS' => [
    'created' => 'Created',
    'updated' => 'Updated',
    'deleted' => 'Deleted',
  ],
  'MODELS' => [
    'admin' => 'App\Models\Admin',
    'roles' => 'App\Models\Role',
    'admin_site_settings' => 'App\Models\AdminSiteSetting',
    'users' => 'App\Models\User',
  ],

  'ADMIN_SITE_SETTINGS' => [
    'SITE_LOGO_SETTING_KEY' => [
      'NAME' => 'SITE_LOGO',
      'TYPE' => 'file',
    ],
    'SITE_FAVICON_SETTING_KEY' => [
      'NAME' => 'SITE_FAVICON',
      'TYPE' => 'file',
    ],
    'SITE_EMAIL_SETTING_KEY' => [
      'NAME' => 'SITE_EMAIL',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Site email',
    ],
    'SITE_PHONE_SETTING_KEY' => [
      'NAME' => 'SITE_PHONE',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Site phone',
    ],
    'SITE_ADDRESS_SETTING_KEY' => [
      'NAME' => 'SITE_ADDRESS',
      'TYPE' => 'textarea',
    ],
    'SITE_GOOGLE_CAPTCHA_ENABLE_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_ENABLE',
      'TYPE' => 'boolean',
      'PLACEHOLDER' => 'Enable Google Captcha V3',
    ],
    'SITE_GOOGLE_CAPTCHA_KEY_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_KEY',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Google recaptcha v3 key',
    ],
    'SITE_GOOGLE_CAPTCHA_SECRET_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_SECRET',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Google recaptcha v3 secret',
    ],
    // 'SITE_CAPTCHA_ENTERPRISE_SETTING_KEY' => [
    //   'NAME' => 'ENABLE_ENTERPRISE_CAPTCHA',
    //   'TYPE' => 'boolean',
    //   'PLACEHOLDER' => 'Enable Enterprise Recaptcha',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_PROJECT_ID_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_PROJECT_ID',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha Project ID',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_SITE_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_SITE_KEY',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha Site Key/Site ID',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_API_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_API_KEY',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha api key',
    // ],

    // 'SITE_FACEBOOK_PAGE_SETTING_KEY' => [
    //   'NAME' => 'FACEBOOK_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Facebook page full url',
    // ],
    // 'SITE_X_PAGE_SETTING_KEY' => [
    //   'NAME' => 'X_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'X page full url',
    // ],
    // 'SITE_LINKED_IN_PAGE_SETTING_KEY' => [
    //   'NAME' => 'LINKED_IN_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Linked-in page full url',
    // ],
    // 'SITE_INSTAGRAM_PAGE_SETTING_KEY' => [
    //   'NAME' => 'INSTAGRAM_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Instagram page full url',
    // ],
    // 'SITE_YOUTUBE_PAGE_SETTING_KEY' => [
    //   'NAME' => 'YOUTUBE_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'YouTube page full url',
    // ],
    // 'SITE_META_TITLE_SETTING_KEY' => [
    //   'NAME' => 'META_TITLE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta title',
    // ],
    // 'SITE_META_SITE_NAME_SETTING_KEY' => [
    //   'NAME' => 'META_SITE_NAME',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta site name',
    // ],
    // 'SITE_META_SITE_URL_SETTING_KEY' => [
    //   'NAME' => 'META_SITE_URL',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta site url',
    // ],
    // 'SITE_META_DESCRIPTION_SETTING_KEY' => [
    //   'NAME' => 'META_DESCRIPTION',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_META_KEYWORDS_SETTING_KEY' => [
    //   'NAME' => 'META_KEYWORDS',
    //   'TYPE' => 'textarea',
    // ],
    'SITE_ROBOT_TEXT_SETTING_KEY' => [
      'NAME' => 'ROBOT_TEXT_CONTENT',
      'TYPE' => 'textarea',
    ],
    // 'SITE_HEADER_SCRIPT_SETTING_KEY' => [
    //   'NAME' => 'HEADER_SCRIPT',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_FOOTER_SCRIPT_SETTING_KEY' => [
    //   'NAME' => 'FOOTER_SCRIPT',
    //   'TYPE' => 'textarea',
    // ],
  ],

  'USER_SITE_SETTINGS' => [
    'SITE_LOGO_SETTING_KEY' => [
      'NAME' => 'SITE_LOGO',
      'TYPE' => 'file',
    ],
    'SITE_FAVICON_SETTING_KEY' => [
      'NAME' => 'SITE_FAVICON',
      'TYPE' => 'file',
    ],
    'SITE_EMAIL_SETTING_KEY' => [
      'NAME' => 'SITE_EMAIL',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Site email',
    ],
    'SITE_PHONE_SETTING_KEY' => [
      'NAME' => 'SITE_PHONE',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Site phone',
    ],
    'SITE_ADDRESS_SETTING_KEY' => [
      'NAME' => 'SITE_ADDRESS',
      'TYPE' => 'textarea',
    ],
    'SITE_GOOGLE_CAPTCHA_ENABLE_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_ENABLE',
      'TYPE' => 'boolean',
      'PLACEHOLDER' => 'Enable Google Captcha V3',
    ],
    'SITE_GOOGLE_CAPTCHA_KEY_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_KEY',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Google recaptcha v3 key',
    ],
    'SITE_GOOGLE_CAPTCHA_SECRET_SETTING_KEY' => [
      'NAME' => 'GOOGLE_CAPTCHA_SECRET',
      'TYPE' => 'text',
      'PLACEHOLDER' => 'Google recaptcha v3 secret',
    ],
    // 'SITE_CAPTCHA_ENTERPRISE_SETTING_KEY' => [
    //   'NAME' => 'ENABLE_ENTERPRISE_CAPTCHA',
    //   'TYPE' => 'boolean',
    //   'PLACEHOLDER' => 'Enable Enterprise Recaptcha',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_PROJECT_ID_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_PROJECT_ID',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha Project ID',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_SITE_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_SITE_KEY',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha Site Key/Site ID',
    // ],
    // 'SITE_CAPTCHA_ENTERPRISE_API_SETTING_KEY' => [
    //   'NAME' => 'ENTERPRISE_CAPTCHA_API_KEY',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Enterprise Captcha api key',
    // ],

    // 'SITE_FACEBOOK_PAGE_SETTING_KEY' => [
    //   'NAME' => 'FACEBOOK_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Facebook page full url',
    // ],
    // 'SITE_X_PAGE_SETTING_KEY' => [
    //   'NAME' => 'X_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'X page full url',
    // ],
    // 'SITE_LINKED_IN_PAGE_SETTING_KEY' => [
    //   'NAME' => 'LINKED_IN_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Linked-in page full url',
    // ],
    // 'SITE_INSTAGRAM_PAGE_SETTING_KEY' => [
    //   'NAME' => 'INSTAGRAM_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Instagram page full url',
    // ],
    // 'SITE_YOUTUBE_PAGE_SETTING_KEY' => [
    //   'NAME' => 'YOUTUBE_PAGE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'YouTube page full url',
    // ],
    // 'SITE_META_TITLE_SETTING_KEY' => [
    //   'NAME' => 'META_TITLE',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta title',
    // ],
    // 'SITE_META_SITE_NAME_SETTING_KEY' => [
    //   'NAME' => 'META_SITE_NAME',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta site name',
    // ],
    // 'SITE_META_SITE_URL_SETTING_KEY' => [
    //   'NAME' => 'META_SITE_URL',
    //   'TYPE' => 'text',
    //   'PLACEHOLDER' => 'Meta site url',
    // ],
    // 'SITE_META_DESCRIPTION_SETTING_KEY' => [
    //   'NAME' => 'META_DESCRIPTION',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_META_KEYWORDS_SETTING_KEY' => [
    //   'NAME' => 'META_KEYWORDS',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_ROBOT_TEXT_SETTING_KEY' => [
    //   'NAME' => 'ROBOT_TEXT_CONTENT',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_HEADER_SCRIPT_SETTING_KEY' => [
    //   'NAME' => 'HEADER_SCRIPT',
    //   'TYPE' => 'textarea',
    // ],
    // 'SITE_FOOTER_SCRIPT_SETTING_KEY' => [
    //   'NAME' => 'FOOTER_SCRIPT',
    //   'TYPE' => 'textarea',
    // ],
  ],
];
