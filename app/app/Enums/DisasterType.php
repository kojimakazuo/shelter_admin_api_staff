<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class DisasterType extends Enum
{
    /** 風水害 */
    const WIND_AND_FLOOD = 'WindAndFlood';
    /** がけ崩れ */
    const ROCKFALL = 'Rockfall';
    /** 地震 */
    const EARTHQUAKE = 'Earthquake';
    /** 大規模火災 */
    const LARGE_SCALE_FIRE = 'LargeScaleFire';
}
