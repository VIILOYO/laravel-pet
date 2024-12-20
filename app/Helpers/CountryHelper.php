<?php

namespace App\Helpers;

use libphonenumber\PhoneNumberUtil;
use Locale;

class CountryHelper
{
    private static PhoneNumberUtil $phoneNumberUtil;

    public static function init(): void
    {
        self::$phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public static function getLocaleByPhone(string $phone): string
    {
        self::init();

        return strtolower(
            self::$phoneNumberUtil->getRegionCodeForNumber(
                self::$phoneNumberUtil->parse($phone)
            )
        );
    }

    public static function getCountryByCode(string $code): string
    {
        return Locale::getDisplayRegion("-$code", 'ru');
    }
}
