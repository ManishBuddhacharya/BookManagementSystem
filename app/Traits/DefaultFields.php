<?php


namespace App\Traits;

trait DefaultFields
{
    public function default($table, $isActive = 0)
    {
        $table->boolean('is_active')->default($isActive);
        $table->boolean('is_deleted')->default(0);
        $table->integer('userc_id')->nullable();
        $table->integer('useru_id')->nullable();
        $table->integer('userd_id')->nullable();
        $table->timestamp('deleted_at')->nullable();
    }

    public function dropdefault($table)
    {
        $table->dropColumn('is_active');
        $table->dropColumn('is_deleted');
        $table->dropColumn('userc_id');
        $table->dropColumn('userd_id');
        $table->dropColumn('useru_id');
        $table->dropColumn('deleted_at');
    }
}
