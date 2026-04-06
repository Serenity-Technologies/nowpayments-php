<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Tests\Unit;

use SerenityTechnologies\NowPayments\QueryBuilders\PaymentListQueryBuilder;
use SerenityTechnologies\NowPayments\QueryBuilders\PayoutListQueryBuilder;
use SerenityTechnologies\NowPayments\Tests\TestCase;

class QueryBuildersTest extends TestCase
{
    /** @test */
    public function payment_list_query_builder_builds_basic_query(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setLimit(50)
            ->setPage(1);

        $query = $builder->build();

        $this->assertEquals(['limit' => 50, 'page' => 1], $query);
    }

    /** @test */
    public function payment_list_query_builder_clamps_limit_between_1_and_500(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setLimit(0);
        $this->assertEquals(['limit' => 1], $builder->build());

        $builder->reset();
        $builder->setLimit(1000);
        $this->assertEquals(['limit' => 500], $builder->build());
    }

    /** @test */
    public function payment_list_query_builder_ensures_page_is_non_negative(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setPage(-5);
        $query = $builder->build();

        $this->assertEquals(0, $query['page']);
    }

    /** @test */
    public function payment_list_query_builder_filters_valid_sort_fields(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setSortBy('created_at')
            ->setOrderBy('desc');

        $query = $builder->build();

        $this->assertEquals('created_at', $query['sort']);
        $this->assertEquals('desc', $query['order']);
    }

    /** @test */
    public function payment_list_query_builder_ignores_invalid_sort_fields(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setSortBy('invalid_field')
            ->setOrderBy('asc');

        $query = $builder->build();

        $this->assertArrayNotHasKey('sort', $query);
        $this->assertEquals('asc', $query['order']);
    }

    /** @test */
    public function payment_list_query_builder_ignores_invalid_order_direction(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setOrderBy('invalid');

        $query = $builder->build();

        $this->assertArrayNotHasKey('order', $query);
    }

    /** @test */
    public function payment_list_query_builder_builds_date_filters(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setDateFrom('2024-01-01')
            ->setDateTo('2024-12-31');

        $query = $builder->build();

        $this->assertEquals('2024-01-01', $query['date_from']);
        $this->assertEquals('2024-12-31', $query['date_to']);
    }

    /** @test */
    public function payment_list_query_builder_builds_complete_query(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setLimit(100)
            ->setPage(2)
            ->setSortBy('payment_status')
            ->setOrderBy('asc')
            ->setDateFrom('2024-01-01')
            ->setDateTo('2024-12-31')
            ->setInvoiceId(12345)
            ->setPaymentStatus('finished')
            ->setPayCurrency('btc')
            ->setPriceCurrency('usd')
            ->setOrderId('ORDER-123');

        $query = $builder->build();

        $this->assertEquals([
            'limit' => 100,
            'page' => 2,
            'sort' => 'payment_status',
            'order' => 'asc',
            'date_from' => '2024-01-01',
            'date_to' => '2024-12-31',
            'invoice_id' => 12345,
            'payment_status' => 'finished',
            'pay_currency' => 'btc',
            'price_currency' => 'usd',
            'order_id' => 'ORDER-123',
        ], $query);
    }

    /** @test */
    public function payment_list_query_builder_filters_valid_payment_statuses(): void
    {
        $statuses = [
            'waiting', 'confirming', 'confirmed', 'sending', 'finished',
            'failed', 'refunded', 'expired', 'partially_paid', 're_deposited',
            'wrong_asset'
        ];

        foreach ($statuses as $status) {
            $builder = new PaymentListQueryBuilder();
            $builder->setPaymentStatus($status);
            $query = $builder->build();

            $this->assertEquals($status, $query['payment_status'], "Failed for status: {$status}");
        }
    }

    /** @test */
    public function payment_list_query_builder_normalizes_payment_status_case(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setPaymentStatus('FINISHED');
        $query = $builder->build();

        $this->assertEquals('finished', $query['payment_status']);
    }

    /** @test */
    public function payment_list_query_builder_normalizes_currency_case(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setPayCurrency('BTC')
            ->setPriceCurrency('USD');

        $query = $builder->build();

        $this->assertEquals('btc', $query['pay_currency']);
        $this->assertEquals('usd', $query['price_currency']);
    }

    /** @test */
    public function payment_list_query_builder_reset_clears_all_filters(): void
    {
        $builder = new PaymentListQueryBuilder();
        $builder->setLimit(50)
            ->setPage(2)
            ->setSortBy('created_at')
            ->setPaymentStatus('finished')
            ->setPayCurrency('btc');

        $builder->reset();
        $query = $builder->build();

        $this->assertEmpty($query);
    }

    /** @test */
    public function payout_list_query_builder_builds_basic_query(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setLimit(50)
            ->setPage(2);

        $query = $builder->build();

        $this->assertEquals(['limit' => 50, 'page' => 2], $query);
    }

    /** @test */
    public function payout_list_query_builder_uses_default_values(): void
    {
        $builder = new PayoutListQueryBuilder();
        $query = $builder->build();

        $this->assertEquals(['limit' => 20, 'page' => 0], $query);
    }

    /** @test */
    public function payout_list_query_builder_builds_complete_query(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setBatchId(12345)
            ->setStatus('finished')
            ->setOrderBy('created_at')
            ->setOrder('desc')
            ->setDateFrom('2024-01-01')
            ->setDateTo('2024-12-31')
            ->setLimit(100)
            ->setPage(3);

        $query = $builder->build();

        $this->assertEquals([
            'limit' => 100,
            'page' => 3,
            'batch_id' => 12345,
            'status' => 'finished',
            'order_by' => 'created_at',
            'order' => 'desc',
            'date_from' => '2024-01-01',
            'date_to' => '2024-12-31',
        ], $query);
    }

    /** @test */
    public function payout_list_query_builder_filters_valid_statuses(): void
    {
        $statuses = ['creating', 'waiting', 'processing', 'sending', 'finished', 'failed', 'rejected', 'cancelled'];

        foreach ($statuses as $status) {
            $builder = new PayoutListQueryBuilder();
            $builder->setStatus($status);
            $query = $builder->build();

            $this->assertEquals($status, $query['status'], "Failed for status: {$status}");
        }
    }

    /** @test */
    public function payout_list_query_builder_ignores_invalid_statuses(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setStatus('invalid_status');

        $query = $builder->build();

        $this->assertArrayNotHasKey('status', $query);
    }

    /** @test */
    public function payout_list_query_builder_normalizes_status_case(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setStatus('FINISHED');

        $query = $builder->build();

        $this->assertEquals('finished', $query['status']);
    }

    /** @test */
    public function payout_list_query_builder_ignores_invalid_order_direction(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setOrder('invalid');

        $query = $builder->build();

        $this->assertArrayNotHasKey('order', $query);
    }

    /** @test */
    public function payout_list_query_builder_ensures_limit_is_positive(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setLimit(-10);

        $query = $builder->build();

        $this->assertEquals(1, $query['limit']);
    }

    /** @test */
    public function payout_list_query_builder_ensures_page_is_non_negative(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setPage(-5);

        $query = $builder->build();

        $this->assertEquals(0, $query['page']);
    }

    /** @test */
    public function payout_list_query_builder_reset_restores_defaults(): void
    {
        $builder = new PayoutListQueryBuilder();
        $builder->setBatchId(12345)
            ->setStatus('finished')
            ->setLimit(100)
            ->setPage(5);

        $builder->reset();
        $query = $builder->build();

        $this->assertEquals(['limit' => 20, 'page' => 0], $query);
    }

    /** @test */
    public function payment_list_query_builder_supports_fluent_interface(): void
    {
        $builder = new PaymentListQueryBuilder();

        $result = $builder->setLimit(10);

        $this->assertInstanceOf(PaymentListQueryBuilder::class, $result);
        $this->assertSame($builder, $result);
    }

    /** @test */
    public function payout_list_query_builder_supports_fluent_interface(): void
    {
        $builder = new PayoutListQueryBuilder();

        $result = $builder->setLimit(10);

        $this->assertInstanceOf(PayoutListQueryBuilder::class, $result);
        $this->assertSame($builder, $result);
    }
}
