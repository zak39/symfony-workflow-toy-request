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

    public static function status(string $status): self {
        return match ($status) {
            self::REQUEST->value => self::REQUEST,
            self::DAD_VALIDATION_PENDING->value => self::DAD_VALIDATION_PENDING,
            self::DAD_OK->value => self::DAD_OK,
            self::MUM_VALIDATION_PENDING->value => self::MUM_VALIDATION_PENDING,
            self::MUM_OK->value => self::MUM_OK,
            self::ORDER->value => self::ORDER,
            self::ORDERED->value => self::ORDERED,
            self::RECEIVED->value => self::RECEIVED,
            default => throw new \Exception('Unknown status: ' . $status),
        };
    }
}
