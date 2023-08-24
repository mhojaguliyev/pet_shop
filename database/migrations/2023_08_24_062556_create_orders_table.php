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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_uuid')->constrained('users', 'uuid');
            $table->foreignUuid('order_status_uuid')->constrained('order_statuses', 'uuid');
            $table->foreignUuid('payment_uuid')->constrained('payments', 'uuid');
            $table->uuid()->index();
            $table->json('products');
            $table->json('address');
            $table->decimal('delivery_fee', 8, 2)->unsigned()->nullable();
            $table->decimal('amount', 12, 2)->unsigned()->default(0);
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
