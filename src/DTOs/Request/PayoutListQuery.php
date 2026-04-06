<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Query DTO for listing payouts with pagination and filtering.
 *
 * @see https://api.nowpayments.io/v1/payout
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutListQuery extends BaseRequestDto
{
    /**
     * @param int|null $batchId Filter by batch ID
     * @param string|null $status Filter by status
     * @param string|null $orderBy Field to sort by
     * @param string|null $order Sort order: "asc" or "desc"
     * @param string|null $dateFrom Filter payouts from this date (ISO 8601)
     * @param string|null $dateTo Filter payouts to this date (ISO 8601)
     * @param int $limit Number of records per page (default: 20)
     * @param int $page Page number (default: 0)
     */
    public function __construct(
        public readonly ?int $batchId = null,
        public readonly ?string $status = null,
        public readonly ?string $orderBy = null,
        public readonly ?string $order = null,
        public readonly ?string $dateFrom = null,
        public readonly ?string $dateTo = null,
        public readonly int $limit = 20,
        public readonly int $page = 0,
    ) {
    }

    public function getBatchId(): ?int
    {
        return $this->batchId;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?string
    {
        return $this->dateTo;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function toArray(): array
    {
        $array = [
            'limit' => $this->limit,
            'page' => $this->page,
        ];

        if ($this->batchId !== null) {
            $array['batch_id'] = $this->batchId;
        }

        if ($this->status !== null) {
            $array['status'] = $this->status;
        }

        if ($this->orderBy !== null) {
            $array['order_by'] = $this->orderBy;
        }

        if ($this->order !== null) {
            $array['order'] = $this->order;
        }

        if ($this->dateFrom !== null) {
            $array['date_from'] = $this->dateFrom;
        }

        if ($this->dateTo !== null) {
            $array['date_to'] = $this->dateTo;
        }

        return $array;
    }

    public function validate(): bool
    {
        if ($this->limit <= 0) {
            throw new \InvalidArgumentException('limit must be greater than zero.');
        }

        if ($this->page < 0) {
            throw new \InvalidArgumentException('page must be zero or greater.');
        }

        if ($this->order !== null && !in_array(strtolower($this->order), ['asc', 'desc'], true)) {
            throw new \InvalidArgumentException('order must be "asc" or "desc".');
        }

        if ($this->status !== null) {
            $allowedStatuses = ['creating', 'waiting', 'processing', 'sending', 'finished', 'failed', 'rejected', 'cancelled'];
            if (!in_array(strtolower($this->status), $allowedStatuses, true)) {
                throw new \InvalidArgumentException('status must be one of: ' . implode(', ', $allowedStatuses));
            }
        }

        return true;
    }
}
