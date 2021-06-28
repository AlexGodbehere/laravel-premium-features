<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateFeaturesTables
 */
class CreateFeaturesTables extends Migration
{

    public function up()
    : void
    {

        Schema::create('features', static function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('cancel_warning')->comment('The string used to warn the user what will happen with this feature if they cancel their membership.');
            $table->string('class_name');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    : void
    {

        Schema::dropIfExists('features');
    }

}
