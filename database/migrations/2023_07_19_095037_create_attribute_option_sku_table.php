<?php

use App\Models\AttributeOption;
use App\Models\Sku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_option_sku', static function (Blueprint $table) {
            $table->foreignId('sku_id')->constrained();
            $table->foreignId('attribute_option_id')->constrained();
        });
    }
};
