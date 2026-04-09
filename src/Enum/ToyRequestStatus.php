<?php

namespace App\Enum;

enum ToyRequestStatus: string
{
    case REQUEST = 'request';
    case DAD_VALIDATION_PENDING = 'dad_validation_pending';
    case DAD_OK = 'dad_ok';
    case MUM_VALIDATION_PENDING = 'mum_validation_pending';
    case MUM_OK = 'mum_ok';
    case ORDER = 'order';
    case ORDERED = 'ordered';
    case RECEIVED = 'received';
}
