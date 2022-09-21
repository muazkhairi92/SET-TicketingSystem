<?php

use App\Models\PriorityLevel;
use Database\Seeders\PriorityLevelSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriorityLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level');
        });
        $seed = new PriorityLevelSeeder();
        $seed->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priority_levels');
    }
}
