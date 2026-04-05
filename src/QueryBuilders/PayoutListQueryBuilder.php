<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\QueryBuilders;

class PayoutListQueryBuilder
{
    protected ?int $batchId = null;
    protected ?string $status = null;
    protected ?string $orderBy = null;
    protected ?string $order = null;
    protected ?string $dateFrom = null;
    protected ?string $dateTo = null;
    protected int $limit = 20;
    protected int $page = 0;

    /**
     * Set batch ID filter.
     */
    public function setBatchId(int $batchId): self
    {
        $this->batchId = $batchId;
        return $this;
    }

    /**
     * Set status filter.
     */
    public function setStatus(string $status): self
    {
        $allowedStatuses = ['creating', 'waiting', 'processing', 'sending', 'finished', 'failed', 'rejected', 'cancelled'];
        
        if (in_array(strtolower($status), $allowedStatuses, true)) {
            $this->status = strtolower($status);
        }
        
        return $this;
    }

    /**
     * Set order by field.
     */
    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * Set sort direction (asc or desc).
     */
    public function setOrder(string $order): self
    {
        if (in_array(strtolower($order), ['asc', 'desc'], true)) {
            $this->order = strtolower($order);
        }
        
        return $this;
    }

    /**
     * Set date from filter.
     */
    public function setDateFrom(string $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * Set date to filter.
     */
    public function setDateTo(string $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * Set limit (default 20).
     */
    public function setLimit(int $limit): self
    {
        $this->limit = max(1, $limit);
        return $this;
    }

    /**
     * Set page number (default 0).
     */
    public function setPage(int $page): self
    {
        $this->page = max(0, $page);
        return $this;
    }

    /**
     * Build query array.
     */
    public function build(): array
    {
        $query = [
            'limit' => $this->limit,
            'page' => $this->page,
        ];

        if ($this->batchId !== null) {
            $query['batch_id'] = $this->batchId;
        }

        if ($this->status !== null) {
            $query['status'] = $this->status;
        }

        if ($this->orderBy !== null) {
            $query['order_by'] = $this->orderBy;
        }

        if ($this->order !== null) {
            $query['order'] = $this->order;
        }

        if ($this->dateFrom !== null) {
            $query['date_from'] = $this->dateFrom;
        }

        if ($this->dateTo !== null) {
            $query['date_to'] = $this->dateTo;
        }

        return $query;
    }

    /**
     * Reset all filters.
     */
    public function reset(): self
    {
        $this->batchId = null;
        $this->status = null;
        $this->orderBy = null;
        $this->order = null;
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->limit = 20;
        $this->page = 0;
        
        return $this;
    }
}
