<?php

namespace Cboxdk\StatamicOverseer\Tests;

use Cboxdk\StatamicOverseer\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
