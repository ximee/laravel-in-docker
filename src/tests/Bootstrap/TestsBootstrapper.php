<?php

declare(strict_types = 1);

namespace Tests\Bootstrap;

use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Config\Repository;
use AvtoDev\DevTools\Tests\PHPUnit\Traits\CreatesApplicationTrait;
use AvtoDev\DevTools\Tests\Bootstrap\AbstractLaravelTestsBootstrapper;

class TestsBootstrapper extends AbstractLaravelTestsBootstrapper
{
    use CreatesApplicationTrait;

    /**
     * Make check - migration is required, or not?
     *
     * @return bool
     */
    protected function bootNeedMigrateIfNeeded(): bool
    {
        global $argv;

        static $skip_arguments = ['--group', '-g', '--help', '--bootstrap'];

        foreach ((array) $argv as $argument) {
            foreach ($skip_arguments as $skip) {
                if (Str::contains(Str::lower(trim($argument)), Str::lower($skip))) {
                    $this->log(sprintf('Skip database refreshing (argument "%s" found)', $argument));

                    return true;
                }
            }
        }

        $this->refreshDatabase();

        return true;
    }

    /**
     * Make database migrating and seeding.
     *
     * @throws RuntimeException
     *
     * @return bool
     */
    protected function refreshDatabase(): void
    {
        /** @var Kernel|null $kernel */
        $kernel = $this->app->make(Kernel::class);

        /** @var Repository $config */
        $config = $this->app->make('config');

        if (($db_connection_name = $config->get('database.default')) === 'sqlite') {
            $this->log("Use database connection [${db_connection_name}]");

            if (! $this->files->exists($db_file_path = $config->get('database.connections.sqlite.database'))) {
                if (($written_bytes = $this->files->put($db_file_path, null)) === false) {
                    throw new RuntimeException("Cannot create empty sqlite file: ${db_file_path}");
                }

                $this->log("Empty sqlite file made, written bytes: ${written_bytes}");
            } else {
                $this->log("File [${db_file_path}] already exists");
            }
        }

        $this->log('Refresh migrations..');
        $kernel->call('migrate:refresh');

        $this->log('Apply seeds..');
        $kernel->call('db:seed');
    }
}
