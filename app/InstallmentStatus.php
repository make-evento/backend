<?php

namespace App;

enum InstallmentStatus : string
{
    case PENDING = "pending";
    case PAID = "paid";
    case LATE = "late";
    case CANCELLED = "cancelled";
}
