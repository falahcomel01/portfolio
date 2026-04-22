<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $compiledViewPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'portfolio-test-views';

        config()->set('view.compiled', $compiledViewPath);
        File::ensureDirectoryExists(config('view.compiled'));
        File::cleanDirectory(config('view.compiled'));

        if ($this->databaseSchemaIsMissing()) {
            Artisan::call('migrate', ['--force' => true]);
        }
    }

    protected function databaseSchemaIsMissing(): bool
    {
        try {
            return ! Schema::hasTable('migrations');
        } catch (Throwable) {
            return true;
        }
    }
}
