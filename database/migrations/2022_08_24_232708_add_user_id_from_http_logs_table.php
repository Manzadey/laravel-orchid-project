<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('http_logs')) {
            return;
        }

        Schema::table('http_logs', function(Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)
                ->after('id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('http_logs', function(Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
