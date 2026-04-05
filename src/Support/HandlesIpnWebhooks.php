<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Support;

use Illuminate\Http\Request;
use SerenityTechnologies\NowPayments\Events\ConversionFinished;
use SerenityTechnologies\NowPayments\Events\PaymentStatusChanged;
use SerenityTechnologies\NowPayments\Events\PayoutCompleted;
use SerenityTechnologies\NowPayments\Handlers\IpnHandler;

/**
 * Trait for handling NOWPayments IPN webhooks in Laravel controllers.
 *
 * Usage:
 * ```php
 * class NowPaymentsWebhookController extends Controller
 * {
 *     use HandlesIpnWebhooks;
 * }
 * ```
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
trait HandlesIpnWebhooks
{
    /**
     * Handle incoming IPN webhook.
     */
    public function __invoke(Request $request, IpnHandler $ipnHandler): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $ipnHandler->handleRequest($request);

            // Fire appropriate event based on payload type
            $this->fireWebhookEvent($data);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * Fire the appropriate event based on webhook payload.
     */
    protected function fireWebhookEvent(array $data): void
    {
        // Payment webhook
        if (isset($data['payment_id'])) {
            PaymentStatusChanged::dispatch(
                $data,
                $data['payment_id'] ?? null,
                $data['payment_status'] ?? null
            );
        }

        // Payout webhook
        if (isset($data['id']) && isset($data['batch_withdrawal_id'])) {
            PayoutCompleted::dispatch(
                $data,
                $data['id'] ?? null,
                $data['status'] ?? null
            );
        }

        // Conversion webhook
        if (isset($data['conversion_id']) || (isset($data['from_currency']) && isset($data['to_currency']))) {
            ConversionFinished::dispatch(
                $data,
                $data['id'] ?? $data['conversion_id'] ?? null
            );
        }
    }
}
