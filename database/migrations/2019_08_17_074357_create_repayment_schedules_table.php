<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayment_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('loan_id');
            $table->date('date');
            $table->float('payment_amount', 32, 2);
            $table->float('principal', 32, 2);
            $table->float('interest', 32, 2);
            $table->float('balance', 32, 2);
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
        Schema::dropIfExists('repayment_schedules');
    }
}
