<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    public bool $autoId = false;

    public function up(): void
    {
        $this->table('slideshow_sliders')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 10,
                    'null' => false,
                    'signed' => false,
                ])
                ->addColumn('title', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => false,
                ])
                ->addColumn('description', 'string', [
                    'default' => null,
                    'limit' => 500,
                    'null' => true,
                ])
                ->addColumn('width', 'integer', [
                    'default' => null,
                    'limit' => 5,
                    'null' => false,
                    'signed' => false,
                ])
                ->addColumn('height', 'integer', [
                    'default' => null,
                    'limit' => 5,
                    'null' => false,
                    'signed' => false,
                ])
                ->addColumn('delay', 'integer', [
                    'default' => '0',
                    'limit' => 5,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey('id')
                ->create();

        $this->table('slideshow_slider_slides')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 10,
                    'null' => false,
                    'signed' => false,
                ])
                ->addColumn('slider_id', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => false,
                    'signed' => false,
                ])
                ->addColumn('title', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('url', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('target', 'string', [
                    'default' => '_self',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('path', 'string', [
                    'default' => null,
                    'limit' => 50,
                    'null' => false
                ])
                ->addColumn('position', 'integer', [
                    'default' => null,
                    'limit' => 5,
                    'null' => true,
                    'signed' => false,
                ])
                ->addColumn('enabled', 'boolean', [
                    'default' => false,
                    'limit' => null,
                    'null' => false,
                ])
                ->addPrimaryKey('id')
                ->addForeignKey('slider_id', 'slideshow_sliders', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE'])
                ->addIndex('slider_id')
                ->create();

        $this->table('slideshow_slider_slides_i18n')
                ->addColumn('id', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'signed' => false,
                    'null' => false,
                ])
                ->addColumn('locale', 'string', [
                    'default' => null,
                    'limit' => 5,
                    'null' => false,
                ])
                ->addColumn('title', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('url', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addPrimaryKey(['id', 'locale'])
                ->create();
    }

    public function down(): void
    {
        $this->table('slideshow_slider_slides_i18n')->drop()->save();
        $this->table('slideshow_slider_slides')->drop()->save();
        $this->table('slideshow_sliders')->drop()->save();
    }
}
