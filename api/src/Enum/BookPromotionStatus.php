<?php

declare(strict_types=1);

namespace App\Enum;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

/**
 * A list of possible conditions for the item.
 *
 * @see https://schema.org/OfferItemCondition
 */
#[ApiResource(
    shortName: 'BookPromotionStatus',
    types: ['https://schema.org/OfferItemCondition'],
    operations: [
        new GetCollection(provider: BookPromotionStatus::class . '::getCases'),
        new Get(provider: BookPromotionStatus::class . '::getCase'),
    ],
)]
enum BookPromotionStatus: string
{
    use EnumApiResourceTrait;

    case NONE = 'None';
    case BASIC = 'Basic';
    case PRO = 'Pro';
}
