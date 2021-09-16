<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateFeaturesTables
 */
class AddMarketingLinesToFeatures extends Migration
{

    public function up()
    : void
    {

        Schema::table('features', function (Blueprint $table) {

            $table->string('marketing_title')->default('')->comment('The title used when advertising the feature to users.');
            $table->string('marketing_description')->default('')->comment('The description used when advertising the feature to users.');
            $table->string('marketing_icon')->default('')->comment('The icon used when advertising the feature to users.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    : void
    {

        Schema::table('features', function (Blueprint $table) {

            $table->dropColumn('marketing_title');
            $table->dropColumn('marketing_description');
            $table->dropColumn('marketing_icon');
        });
    }

}
