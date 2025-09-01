<?php

namespace Webkul\Lord\Tests\Concerns;

use Webkul\Customer\Contracts\Customer as CustomerContract;
use Webkul\Faker\Helpers\Customer as CustomerFaker;

trait LordTestBench
{
    /**
     * Login as customer.
     */
    public function loginAsCustomer(?CustomerContract $customer = null): CustomerContract
    {
        $customer = $customer ?? (new CustomerFaker)->factory()->create();

        $this->actingAs($customer);

        return $customer;
    }
}
