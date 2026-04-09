<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Services;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\PlanRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\SubscriptionRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\PlanResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PlanListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\SubscriptionResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\SubscriptionListResponse;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

/**
 * Endpoint for subscription-related operations.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriptionService
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Create a new subscription plan.
     *
     * @param PlanRequest $request
     * @return PlanResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions/plans
     */
    public function createPlan(PlanRequest $request): PlanResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/subscriptions/plans', $request->toArray(), requiresAuth: true);

        return PlanResponse::fromArray($response);
    }

    /**
     * List subscription plans with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return PlanListResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions/plans
     */
    public function listPlans(array $filters = []): PlanListResponse
    {
        $response = $this->client->get('/v1/subscriptions/plans', $filters, requiresAuth: false);

        return PlanListResponse::fromArray($response);
    }

    /**
     * Get a subscription plan by ID.
     *
     * @param string $planId The plan ID
     * @return PlanResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions/plans/{id}
     */
    public function getPlan(string $planId): PlanResponse
    {
        $response = $this->client->get('/v1/subscriptions/plans/' . $planId, query: [], requiresAuth: false);

        return PlanResponse::fromArray($response);
    }

    /**
     * Update a subscription plan by ID.
     *
     * @param string $planId The plan ID
     * @param array<string, mixed> $data The plan data
     * @return PlanResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions/plans/{id}
     */
    public function updatePlan(string $planId, array $data): PlanResponse
    {
        $response = $this->client->patch('/v1/subscriptions/plans/' . $planId, $data, requiresAuth: true);

        return PlanResponse::fromArray($response);
    }

    /**
     * Create a new subscription.
     *
     * @param SubscriptionRequest $request
     * @return SubscriptionResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions
     */
    public function createSubscription(SubscriptionRequest $request): SubscriptionResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/subscriptions', $request->toArray(), requiresAuth: true);

        return SubscriptionResponse::fromArray($response);
    }

    /**
     * List subscriptions with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return SubscriptionListResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions
     */
    public function listSubscriptions(array $filters = []): SubscriptionListResponse
    {
        $response = $this->client->get('/v1/subscriptions', $filters, requiresAuth: false);

        return SubscriptionListResponse::fromArray($response);
    }

    /**
     * Get a subscription by ID.
     *
     * @param string $subId The subscription ID
     * @return SubscriptionResponse
     *
     * @see https://api.nowpayments.io/v1/subscriptions/{id}
     */
    public function getSubscription(string $subId): SubscriptionResponse
    {
        $response = $this->client->get('/v1/subscriptions/' . $subId, query: [], requiresAuth: false);

        return SubscriptionResponse::fromArray($response);
    }

    /**
     * Delete a subscription by ID.
     *
     * @param string $subId The subscription ID
     * @return bool
     *
     * @see https://api.nowpayments.io/v1/subscriptions/{id}
     */
    public function deleteSubscription(string $subId): bool
    {
        $this->client->delete('/v1/subscriptions/' . $subId, requiresAuth: true);

        return true;
    }
}
