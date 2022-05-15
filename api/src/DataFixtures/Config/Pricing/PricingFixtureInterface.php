<?php

namespace App\DataFixtures\Config\Pricing;

interface PricingFixtureInterface
{
    public const OFFERS = [
        0 => [
            'identifier' => 'offer_text_message',
            'name'       => 'Message écrit',
        ],
        1 => [
            'identifier' => 'offer_audio_message',
            'name'       => 'Message audio',
        ],
        2 => [
            'identifier' => 'offer_picture_message',
            'name'       => 'Photo',
        ],
        3 => [
            'identifier' => 'offer_video_message',
            'name'       => 'Message vidéo',
        ],
        4 => [
            'identifier' => 'offer_last_will',
            'name'       => 'Testament',
        ],
        5 => [
            'identifier' => 'offer_testimony',
            'name'       => 'Témoignage',
        ],
        6 => [
            'identifier' => 'offer_boomerang',
            'name'       => 'Boomerang',
        ],
        7 => [
            'identifier' => 'offer_dream_transmission',
            'name'       => 'Tramission de rêve',
        ],
        8 => [
            'identifier' => 'offer_hologramme',
            'name'       => 'Hologramme',
        ],
    ];

    public const PLANS = [
        0 => [
            'level'       => 0,
            'identifier'  => 'plan_kapsily_white',
            'label'       => 'Une journée dans votre vie',
            'description' => 'Kapisily fotsy description',
            'minds'       => 0,
            'years'       => 10,
        ],
        1 => [
            'level'       => 1,
            'identifier'  => 'plan_kapsily_yellow',
            'label'       => "L'essentiel",
            'description' => 'Kapisily mavo description',
            'minds'       => 50,
            'years'       => 50,
        ],
        2 => [
            'level'       => 2,
            'identifier'  => 'plan_kapsily_gold',
            'label'       => 'Message de la cygone',
            'description' => 'Kapisily kely description',
            'minds'       => 150,
            'years'       => 1000,
        ],
    ];

    public const OFFER_PLANS = [
        self::PLANS[0]['identifier'] => [
            'offer_' . self::OFFERS[0]['identifier'],
            'offer_' . self::OFFERS[1]['identifier'],
            'offer_' . self::OFFERS[2]['identifier'],
            'offer_' . self::OFFERS[3]['identifier'],
        ],
        self::PLANS[1]['identifier'] => [
            'offer_' . self::OFFERS[4]['identifier'],
            'offer_' . self::OFFERS[5]['identifier'],
        ],
        self::PLANS[2]['identifier'] => [
            'offer_' . self::OFFERS[6]['identifier'],
            'offer_' . self::OFFERS[7]['identifier'],
            'offer_' . self::OFFERS[8]['identifier'],
        ],
    ];
}
