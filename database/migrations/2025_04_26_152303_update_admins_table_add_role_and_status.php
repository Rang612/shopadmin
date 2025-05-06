<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminsTableAddRoleAndStatus extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Chỉ thêm cột nếu chưa tồn tại
            if (!Schema::hasColumn('admins', 'role')) {
                $table->enum('role', ['super_admin', 'admin', 'support_staff'])->default('admin');
            }

            if (!Schema::hasColumn('admins', 'status')) {
                $table->boolean('status')->default(true);
            }
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('status');
        });
    }
}
