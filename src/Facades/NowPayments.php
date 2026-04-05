<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Facades;

use Illuminate\Support\Facades\Facade;
use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;

/**
 * @method static array get(string $uri, array $query = [], bool $requiresAuth = false)
 * @method static array post(string $uri, array $data = [], bool $requiresAuth = false)
 * @method static array patch(string $uri, array $data = [], bool $requiresAuth = false)
 * @method static array delete(string $uri, bool $requiresAuth = false)
 * @method static string getJwtToken()
 * @method static NowPaymentsClient setJwtToken(string $token)
 * @method static string getApiKey()
 * @method static string getIpnSecret()
 *
 * @see \SerenityTechnologies\NowPayments\Client\NowPaymentsClient
 */
class NowPayments extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'nowpayments';
    }
}
