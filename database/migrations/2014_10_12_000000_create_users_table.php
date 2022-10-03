<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->nullable()->unique();

			$table->string('username')->unique();
			$table->string('role', 32)->default(User::ROLE_USER);

			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();

			$table->softDeletes();

		});

		DB::table('users')->insert([
			[
				'name' => 'Dima Boro',
				'username' => 'theboro',
				'email' => 'iboro770@gmail.com',
				'password' => Hash::make('password'),
				'role' => User::ROLE_ADMIN,
				'created_at' => now(),
			],
			[
				'name' => 'Demo',
				'username' => 'demo',
				'email' => 'demo@example.com',
				'password' => Hash::make('demo'),
				'role' => User::ROLE_EDITOR,
				'created_at' => now(),
			],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
};
