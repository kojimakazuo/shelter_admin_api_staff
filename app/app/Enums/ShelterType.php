<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class ShelterType extends Enum
{
    /** 緊急避難所 */
    const EMERGENCY = 'Emergency';
    /** 避難所 */
    const NORMAL = 'Normal';
}
