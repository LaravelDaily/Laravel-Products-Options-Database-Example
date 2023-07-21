<?php

use App\Models\Attribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_options', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Attribute::class)->constrained();
            $table->string('value');
            $table->timestamps();
        });
    }
};
