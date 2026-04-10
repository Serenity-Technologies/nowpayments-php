<?php

namespace SerenityTechnologies\NowPayments\Enums;

enum FaitPayoutStatus: string
{

    case CREATING = 'CREATING';
    case CONVERTING = 'CONVERTING';
    case DEPOSITING = 'DEPOSITING';
    case PROCESSING = 'PROCESSING';
    case FINISHED = 'FINISHED';
    case FAILED = 'FAILED';
}
