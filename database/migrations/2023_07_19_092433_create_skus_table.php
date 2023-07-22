<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skus', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('code');
            $table->integer('price');
            $table->timestamps();
        });
    }
};
