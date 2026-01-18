<?php

use App\Models\User;
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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->string('street');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip', 10);
            $table->string('country', 2);
            $table->string('phone', 20);
            $table->string('email');
            $table->string('length', 20);
            $table->string('width', 20);
            $table->string('height', 20);
            $table->string('weight', 20);
            $table->string('label_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
