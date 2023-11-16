<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            if (Schema::hasColumn('images', 'blog_post_id')) {
                $table->dropColumn('blog_post_id');
            }

            $table->morphs('imageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            if (!Schema::hasColumn('images', 'blog_post_id')) {
                $table->unsignedBigInteger('blog_post_id')->nullable();
            }
            if (Schema::hasColumns('images', ['imageable_id', 'imageable_type'])) {
                $table->dropMorphs('imageable');
            }

        });
    }
}
