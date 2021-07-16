<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class StaffRole extends Enum
{
    /** 管理者 */
    const ADMIN = 'Admin';
    /** 一般 */
    const GENERAL = 'General';
}
