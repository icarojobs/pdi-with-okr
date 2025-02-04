<?php

declare(strict_types=1);

it('has frontend/home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
