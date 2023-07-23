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
        Schema::create('bank_payouts', function (Blueprint $table) {
            $table->id();            
            $table->string("bank_name");
            $table->date("start_date");
            $table->date("end_date");
            $table->Integer("min_loan");
            $table->Integer("max_loan");
            $table->string("loan_type");
            $table->string("frequency");
            $table->string("rate_of_commission");
            $table->string("incentive_releasestte");
            $table->string("condition");
            $table->string("cutout_statement");
            $table->string("extra_payout");
            $table->string("remark");
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
        Schema::dropIfExists('bank_payouts');
    }
};
