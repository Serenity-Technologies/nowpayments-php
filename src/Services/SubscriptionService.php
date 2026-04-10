<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Services;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\PlanRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\UpdatePlanRequest;
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
        $data = PlanResponse::unwrapResult($response);

        return PlanResponse::fromArray($data);
    }

    /**
     * List subscription plans with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return PlanListResponse
     *
     * @throws NowPaymentsException
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
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions/plans/{id}
     */
    public function getPlan(string|int $planId): PlanResponse
    {
        $response = $this->client->get('/v1/subscriptions/plans/' . $planId, query: [], requiresAuth: false);
        $data = PlanResponse::unwrapResult($response);

        return PlanResponse::fromArray($data);
    }

    /**
     * Update a subscription plan by ID.
     *
     * @param string|int $planId The plan ID
     * @param UpdatePlanRequest $request The plan update data
     * @return PlanResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions/plans/{id}
     */
    public function updatePlan(string|int $planId, UpdatePlanRequest $request): PlanResponse
    {
        $request->validate();
        $response = $this->client->patch('/v1/subscriptions/plans/' . $planId, $request->toArray(), requiresAuth: true);
        $result = PlanResponse::unwrapResult($response);

        return PlanResponse::fromArray($result);
    }

    /**
     * Create a new subscription.
     *
     * @param SubscriptionRequest $request
     * @return SubscriptionResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions
     */
    public function createSubscription(SubscriptionRequest $request): SubscriptionResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/subscriptions', $request->toArray(), requiresAuth: true);
        $data = SubscriptionResponse::unwrapResult($response);

        return SubscriptionResponse::fromArray($data);
    }

    /**
     * List subscriptions with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return SubscriptionListResponse
     *
     * @throws NowPaymentsException
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
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions/{id}
     */
    public function getSubscription(string $subId): SubscriptionResponse
    {
        $response = $this->client->get('/v1/subscriptions/' . $subId, query: [], requiresAuth: false);
        $data = SubscriptionResponse::unwrapResult($response);

        return SubscriptionResponse::fromArray($data);
    }

    /**
     * Delete a subscription by ID.
     *
     * @param string $subId The subscription ID
     * @return bool
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/subscriptions/{id}
     */
    public function deleteSubscription(string $subId): bool
    {
        $this->client->delete('/v1/subscriptions/' . $subId, requiresAuth: true);

        return true;
    }
}
