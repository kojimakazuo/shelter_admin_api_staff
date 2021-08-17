<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class EntryHistoryType extends Enum
{
    /** 入場 */
    const ENTRY = 'Entry';
    /** 一時退室 */
    const OUT = 'Out';
    /** 再入場 */
    const IN = 'In';
    /** 退場 */
    const EXIT = 'Exit';
}
