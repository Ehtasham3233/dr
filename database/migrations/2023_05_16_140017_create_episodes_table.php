<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            //        'status', 'drama_id', 'title','slug','home_recent','home_kshow','episodes_no',
        //'type', 'date', 'download_url', 'meta_title', 'meta_kwd', 'meta_desc',
        //'description', 'ip', 'created_by', 'updated_by', 'serv_id', 'reff_url'
        $table->id();
        $tble->
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
