<?php

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
        Schema::create('bank_payout_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payout_id')->constrained('bank_payouts');
            $table->text('type_of_condition');
            $table->Integer('rate');
            $table->Integer('amount');
            $table->timestamps();
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
        Schema::dropIfExists('bank_payout_structure');
    }
};
