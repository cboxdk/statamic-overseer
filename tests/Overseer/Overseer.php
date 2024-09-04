<?php

uses(\Cboxdk\StatamicOverseer\Tests\TestCase::class);

test('overseer is enabled', function () {
    expect(\Cboxdk\StatamicOverseer\Facades\Overseer::isTracking())->toBeTrue();
});
