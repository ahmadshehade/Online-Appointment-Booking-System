<?php

namespace Modules\Payments\Enum;


/**
 * Summary of PaymentStatus
 */
enum PaymentStatus: string
{

    case Pending = "pending";

    case Completed = "completed";

    case Failed = "failed";
}
