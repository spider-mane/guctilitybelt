<?php

namespace WebTheory\GuctilityBelt;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Phone
{
    /**
     *
     */
    public static function formatUS(string $phoneNumber, string $format = '-')
    {
        $pattern = "(\\d{3})(\\d{3})(\\d{4})";

        $formats = [
            '-' => "\$1-\$2-\$3",
            '.' => "\$1.\$2.\$3",
            ' ' => "\$1 \$2 \$3",
            '(' => "(\$1) \$2-\$3",
            '' => "\$1\$2\$3",
        ];

        $newFormats[] = (new NumberFormat)
            ->setPattern($pattern)
            ->setFormat($formats[$format]);

        $phoneUtil = PhoneNumberUtil::getInstance();

        $phoneNumber = $phoneUtil->parse($phoneNumber, 'US');

        $phoneNumber = $phoneUtil->formatByPattern($phoneNumber, PhoneNumberFormat::NATIONAL, $newFormats);

        return $phoneNumber;
    }

    /**
     *
     */
    public static function getPhoneLink($phoneNumber, $region = 'US')
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $phoneNumber = $phoneUtil->parse($phoneNumber, $region);
        $phoneNumber = $phoneUtil->format($phoneNumber, PhoneNumberFormat::RFC3966);

        return $phoneNumber;
    }
}
