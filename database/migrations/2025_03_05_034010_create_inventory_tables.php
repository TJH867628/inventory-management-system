<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product name
            $table->string('brand_id')->constrained('brand')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('item_categories')->onDelete('set null');
            $table->text('spec')->nullable();
            $table->timestamps();
        });

        Schema::create('brand', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('mac')->unique()->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        Schema::create('item_allocation', function (Blueprint $table) {
            $table->foreignId('item_id')->primary()->constrained('items')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('from_location')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('to_location')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('from_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('to_user')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reason')->nullable();
            $table->timestamp('transfer_date')->useCurrent();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('details'); // Store change details in JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('transfer_logs');
        Schema::dropIfExists('item_allocations');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('items');
        Schema::dropIfExists('products');
        Schema::dropIfExists('item_categories');
    }
};