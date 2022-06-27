<?php

use App\Models\Order;
use App\Models\Vendor;
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
        Schema::create('delay_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->foreignIdFor(Order::class);
            $table->smallInteger('delay_time')->default(0);
            $table->date('date_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delay_reports');
    }
};
