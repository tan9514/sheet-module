<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDeliveryTable extends Migration
{
    public $tableName = "delivery";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->tableName)) $this->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }

    /**
     * 执行创建表
     */
    private function create()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';      // 设置存储引擎
            $table->charset = 'utf8';       // 设置字符集
            $table->collation  = 'utf8_general_ci';       // 设置排序规则

            $table->id();
            $table->unsignedInteger('express_id')->nullable(false)->comment("快递公司ID")->index("express_id_index");
            $table->string('customer_name')->nullable(false)->comment("电子面单客户账号")->unique("customer_name_unique");
            $table->string("customer_pwd")->nullable(false)->comment("电子面单密码");
            $table->string("month_code")->nullable(false)->comment("月结编码");
            $table->string("send_site")->nullable(false)->comment("网点编码");
            $table->string("send_name")->nullable(false)->comment("网点名称");
            $table->string("company")->nullable(false)->comment("发件人公司");
            $table->string("name")->nullable(false)->comment("发件人名称");
            $table->string("tel")->nullable(false)->comment("发件人电话");
            $table->string("mobile")->nullable(false)->comment("发件人手机");
            $table->string("post_code")->nullable(false)->comment("发件人邮编");
            $table->string("province")->nullable(false)->comment("发件人地址-省市");
            $table->string("city")->nullable(false)->comment("发件人地址-城市");
            $table->string("exp_area")->nullable(false)->comment("发件人地址-区县");
            $table->string("address")->nullable(false)->comment("发件人地址-详细");
            $table->timestamps();
        });
        $prefix = DB::getConfig('prefix');
        $qu = "ALTER TABLE " . $prefix . $this->tableName . " comment '面单打印设置表'";
        DB::statement($qu);
    }
}
