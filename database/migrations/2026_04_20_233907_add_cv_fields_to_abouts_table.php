<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'name' => fn (Blueprint $table) => $table->string('name')->nullable(),
            'title' => fn (Blueprint $table) => $table->string('title')->nullable(),
            'phone' => fn (Blueprint $table) => $table->string('phone')->nullable(),
            'email' => fn (Blueprint $table) => $table->string('email')->nullable(),
            'linkedin' => fn (Blueprint $table) => $table->string('linkedin')->nullable(),
            'website' => fn (Blueprint $table) => $table->string('website')->nullable(),
            'address' => fn (Blueprint $table) => $table->string('address')->nullable(),
            'summary' => fn (Blueprint $table) => $table->text('summary')->nullable(),
            'soft_skills' => fn (Blueprint $table) => $table->text('soft_skills')->nullable(),
            'hard_skills' => fn (Blueprint $table) => $table->text('hard_skills')->nullable(),
        ];

        foreach ($columns as $column => $definition) {
            if (Schema::hasColumn('abouts', $column)) {
                continue;
            }

            Schema::table('abouts', function (Blueprint $table) use ($definition) {
                $definition($table);
            });
        }
    }

    public function down(): void
    {
        $columns = [
            'name',
            'title',
            'phone',
            'email',
            'linkedin',
            'website',
            'address',
            'summary',
            'soft_skills',
            'hard_skills',
        ];

        $existingColumns = array_values(array_filter(
            $columns,
            fn (string $column) => Schema::hasColumn('abouts', $column)
        ));

        if ($existingColumns === []) {
            return;
        }

        Schema::table('abouts', function (Blueprint $table) use ($existingColumns) {
            $table->dropColumn($existingColumns);
        });
    }
};
