<?php

namespace Modules\Appointments\Enum;

enum AppointmentStatus: string
{

    case Pending = "pending";
    case Confirmed = "confirmed";
    case Cancelled = "cancelled";
}
