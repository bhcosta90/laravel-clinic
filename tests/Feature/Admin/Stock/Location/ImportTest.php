<?php

declare(strict_types = 1);

test('', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
