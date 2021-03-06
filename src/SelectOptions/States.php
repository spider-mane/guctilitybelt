<?php

namespace WebTheory\GuctilityBelt\SelectOptions;

/**
 * Class States
 * @package WebTheory\GuctilityBelt\SelectOptions
 */
class States
{
    /**
     *
     */
    public const STATES = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    /**
     *
     */
    public const TERRITORIES = [
        "AS" => "American Samoa",
        "GU" => "Guam",
        "MP" => "Northern Mariana Islands",
        "PR" => "Puerto Rico",
        "UM" => "United States Minor Outlying Islands",
        "VI" => "Virgin Islands",
    ];

    /**
     *
     */
    public const ARMED_FORCES = [
        "AA" => "Armed Forces Americas",
        "AP" => "Armed Forces Pacific",
        "AE" => "Armed Forces Other",
    ];

    /**
     * @param string|null $placeholder
     * @param array $additions
     * @param bool $sort
     * @return array|mixed
     */
    public static function states(?string $placeholder = null, array $additions = [], bool $sort = false)
    {
        $states = static::STATES;

        foreach ($additions as $addition) {
            $states = $states + $addition;
        }

        if (!empty($additions) && $sort) {
            ksort($states);
        }

        if ($placeholder) {
            $states = ['' => $placeholder] + $states;
        }

        return $states;
    }

    /**
     *
     */
    public static function territories()
    {
        return static::TERRITORIES;
    }

    /**
     *
     */
    public static function armedForces()
    {
        return static::ARMED_FORCES;
    }
}
