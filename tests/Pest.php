<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');
