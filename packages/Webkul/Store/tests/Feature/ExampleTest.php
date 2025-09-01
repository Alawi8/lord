<?php

test('the store returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
