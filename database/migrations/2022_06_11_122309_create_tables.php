<?php

use App\Models\Link;
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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visits')->default(0);
            $table->string('domain')->nullable();
            $table->string('slug');
            $table->string('app_url')->nullable();
            $table->string('android_url')->nullable();
            $table->string('huawei_url')->nullable();
            $table->string('ios_url')->nullable();
            $table->string('fallback_url')->nullable();
            $table->text('html')->nullable();
            $table->timestamps();

            $table->unique(['domain', 'slug']);
            $table->index(['created_at']);
            $table->index(['visits']);
            $table->index(['slug']);
        });

        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->dateTime('visited_at');
            $table->foreignIdFor(Link::class, 'link_id');
            $table->string('user_agent');

            $table->index(['visited_at', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
        Schema::dropIfExists('links');
    }
};
