<?php

namespace WebTheory\GuctilityBelt;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * Class Phone
 * @package WebTheory\GuctilityBelt
 */
class Phone
{
    /**
     * @param string $phoneNumber
     * @param string $format
     * @return String
     * @throws \libphonenumber\NumberParseException
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

        $newFormats[] = (new NumberFormat())
            ->setPattern($pattern)
            ->setFormat($formats[$format]);

        $phoneUtil = PhoneNumberUtil::getInstance();

        $phoneNumber = $phoneUtil->parse($phoneNumber, 'US');

        return $phoneUtil->formatByPattern(
            $phoneNumber,
            PhoneNumberFormat::NATIONAL,
            $newFormats
        );
    }

    /**
     * @param $phoneNumber
     * @param string $region
     * @return string
     * @throws \libphonenumber\NumberParseException
     */
    public static function getPhoneLink($phoneNumber, $region = 'US')
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $phoneNumber = $phoneUtil->parse($phoneNumber, $region);

        return $phoneUtil->format($phoneNumber, PhoneNumberFormat::RFC3966);
    }
}
