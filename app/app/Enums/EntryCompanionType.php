<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class EntryCompanionType extends Enum
{
    /** 無し */
    const NONE = 'None';
    /** 同居家族 */
    const FAMILY = 'Family';
    /** その他 */
    const OTHER = 'Other';
}
