<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHtmlcontentToLaraTicketsAndComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laratickets', function (Blueprint $table) {
            $table->longText('html')->nullable()->after('content');
        });

        Schema::table('laratickets_comments', function (Blueprint $table) {
            $table->longText('html')->nullable()->after('content');
            $table->longText('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laratickets', function (Blueprint $table) {
            $table->dropColumn('html');
        });

        Schema::table('laratickets_comments', function (Blueprint $table) {
            $table->dropColumn('html');
            $table->text('content')->change();
        });
    }
}
