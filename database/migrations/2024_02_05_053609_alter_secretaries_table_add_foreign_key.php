<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSecretariesTableAddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secretaries', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['doctors_id']);
            
            // Add a new foreign key with the updated reference column
            $table->foreign('doctors_id')->references('user_id')->on('doctors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secretaries', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['doctors_id']);

            // Add the original foreign key
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('set null');
        });
    }
}
