<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class Condition extends Enum
{
    /** 利用可能 */
    const AVAILABLE = 'Available';
    /** 利用不可 */
    const UNAVAILABLE = 'Unavailable';
}
