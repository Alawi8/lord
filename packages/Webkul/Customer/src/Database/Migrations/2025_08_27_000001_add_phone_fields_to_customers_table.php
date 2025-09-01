<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'phone_otp')) {
                $table->string('phone_otp')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('customers', 'phone_otp_expires_at')) {
                $table->timestamp('phone_otp_expires_at')->nullable()->after('phone_otp');
            }
            
            if (!Schema::hasColumn('customers', 'phone_verified')) {
                $table->boolean('phone_verified')->default(false)->after('phone_otp_expires_at');
            }
            
            if (!Schema::hasColumn('customers', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone_verified');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'phone_otp',
                'phone_otp_expires_at', 
                'phone_verified',
                'phone_verified_at'
            ]);
        });
    }
};