<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\QueryBuilders;

class PaymentListQueryBuilder
{
    protected ?int $limit = null;
    protected ?int $page = null;
    protected ?string $sortBy = null;
    protected ?string $orderBy = null;
    protected ?string $dateFrom = null;
    protected ?string $dateTo = null;
    protected ?int $invoiceId = null;

    /**
     * Set limit (1-500).
     */
    public function setLimit(int $limit): self
    {
        $this->limit = min(500, max(1, $limit));
        return $this;
    }

    /**
     * Set page number.
     */
    public function setPage(int $page): self
    {
        $this->page = max(0, $page);
        return $this;
    }

    /**
     * Set sort field.
     */
    public function setSortBy(string $sortBy): self
    {
        $allowedFields = [
            'payment_id', 'payment_status', 'pay_address', 'price_amount',
            'price_currency', 'pay_amount', 'actually_paid', 'pay_currency',
            'order_id', 'order_description', 'purchase_id', 'outcome_amount',
            'outcome_currency'
        ];
        
        if (in_array($sortBy, $allowedFields, true)) {
            $this->sortBy = $sortBy;
        }
        
        return $this;
    }

    /**
     * Set sort order (asc or desc).
     */
    public function setOrderBy(string $orderBy): self
    {
        if (in_array(strtolower($orderBy), ['asc', 'desc'], true)) {
            $this->orderBy = strtolower($orderBy);
        }
        
        return $this;
    }

    /**
     * Set date from filter (YYYY-MM-DD or ISO 8601).
     */
    public function setDateFrom(string $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * Set date to filter (YYYY-MM-DD or ISO 8601).
     */
    public function setDateTo(string $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * Set invoice ID filter.
     */
    public function setInvoiceId(int $invoiceId): self
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    /**
     * Build query array.
     */
    public function build(): array
    {
        $query = [];

        if ($this->limit !== null) {
            $query['limit'] = $this->limit;
        }

        if ($this->page !== null) {
            $query['page'] = $this->page;
        }

        if ($this->sortBy !== null) {
            $query['sort'] = $this->sortBy;
        }

        if ($this->orderBy !== null) {
            $query['order'] = $this->orderBy;
        }

        if ($this->dateFrom !== null) {
            $query['date_from'] = $this->dateFrom;
        }

        if ($this->dateTo !== null) {
            $query['date_to'] = $this->dateTo;
        }

        if ($this->invoiceId !== null) {
            $query['invoice_id'] = $this->invoiceId;
        }

        return $query;
    }

    /**
     * Reset all filters.
     */
    public function reset(): self
    {
        $this->limit = null;
        $this->page = null;
        $this->sortBy = null;
        $this->orderBy = null;
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->invoiceId = null;
        
        return $this;
    }
}
