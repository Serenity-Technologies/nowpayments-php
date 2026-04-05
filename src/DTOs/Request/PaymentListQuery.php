<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Query DTO for listing payments with pagination and filtering.
 *
 * @see https://api.nowpayments.io/v1/payment/
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PaymentListQuery extends BaseRequestDto
{
    /**
     * @param int|null $limit Number of records per page (default: 10, max: 500)
     * @param int|null $page Page number
     * @param string|null $sortBy Field to sort by
     * @param string|null $orderBy Sort order: "asc" or "desc"
     * @param string|null $dateFrom Filter payments from this date (ISO 8601)
     * @param string|null $dateTo Filter payments to this date (ISO 8601)
     * @param string|null $paymentStatus Filter by payment status
     * @param string|null $payCurrency Filter by payment currency
     * @param string|null $priceCurrency Filter by price currency
     * @param string|null $orderId Filter by order ID
     */
    public function __construct(
        private readonly ?int $limit = null,
        private readonly ?int $page = null,
        private readonly ?string $sortBy = null,
        private readonly ?string $orderBy = null,
        private readonly ?string $dateFrom = null,
        private readonly ?string $dateTo = null,
        private readonly ?string $paymentStatus = null,
        private readonly ?string $payCurrency = null,
        private readonly ?string $priceCurrency = null,
        private readonly ?string $orderId = null,
    ) {
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?string
    {
        return $this->dateTo;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function getPayCurrency(): ?string
    {
        return $this->payCurrency;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function toArray(): array
    {
        $array = [];

        if ($this->limit !== null) {
            $array['limit'] = $this->limit;
        }

        if ($this->page !== null) {
            $array['page'] = $this->page;
        }

        if ($this->sortBy !== null) {
            $array['sort'] = $this->sortBy;
        }

        if ($this->orderBy !== null) {
            $array['order'] = $this->orderBy;
        }

        if ($this->dateFrom !== null) {
            $array['date_from'] = $this->dateFrom;
        }

        if ($this->dateTo !== null) {
            $array['date_to'] = $this->dateTo;
        }

        if ($this->paymentStatus !== null) {
            $array['payment_status'] = $this->paymentStatus;
        }

        if ($this->payCurrency !== null) {
            $array['pay_currency'] = $this->payCurrency;
        }

        if ($this->priceCurrency !== null) {
            $array['price_currency'] = $this->priceCurrency;
        }

        if ($this->orderId !== null) {
            $array['order_id'] = $this->orderId;
        }

        return $array;
    }

    public function validate(): bool
    {
        if ($this->limit !== null && $this->limit <= 0) {
            throw new \InvalidArgumentException('limit must be greater than zero.');
        }

        if ($this->page !== null && $this->page < 0) {
            throw new \InvalidArgumentException('page must be zero or greater.');
        }

        if ($this->orderBy !== null && !in_array(strtolower($this->orderBy), ['asc', 'desc'], true)) {
            throw new \InvalidArgumentException('order must be "asc" or "desc".');
        }

        return true;
    }
}
