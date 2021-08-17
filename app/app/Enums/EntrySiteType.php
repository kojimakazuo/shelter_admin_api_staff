<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class EntrySiteType extends Enum
{
    /** 一般 */
    const GENERAL = 'General';
    /** 体調不良者向け */
    const BAD_CONDITION = 'BadCondition';
    /** 車中泊 */
    const CAR = 'Car';
}
