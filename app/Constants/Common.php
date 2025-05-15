<?php

namespace App\Constants;

class Common
{
    const DEFAULT_PAGINATION = 12;

    const ORDER_LATEST_REGISTER = '0';
    const ORDER_OLD_REGISTER = '1';
    const ORDER_LATEST = '2';
    const ORDER_OLDER = '3';

    const SORT_ORDER = [
        'latestRegisterItem' => self::ORDER_LATEST_REGISTER,
        'oldRegisteredItem' => self::ORDER_OLD_REGISTER,
        'newItem' => self::ORDER_LATEST,
        'oldItem' => self::ORDER_OLDER,
    ];

}
