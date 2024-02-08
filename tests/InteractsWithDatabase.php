<?php

namespace Javaabu\Helpers\Tests;

trait InteractsWithDatabase
{
    protected function runMigrations()
    {
        include_once __DIR__ . '/database/create_categories_table.php';

        (new \CreateCategoriesTable)->up();
    }
}
