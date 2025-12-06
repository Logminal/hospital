<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--name=} {--pole=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать нового администратора';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Введите имя администратора');
        $pole = $this->option('pole') ?: $this->ask('Введите логин (pole)');
        $password = $this->option('password') ?: $this->secret('Введите пароль (минимум 6 символов)');

        // Валидация
        if (empty($name)) {
            $this->error('Имя не может быть пустым!');
            return 1;
        }

        if (empty($pole)) {
            $this->error('Логин не может быть пустым!');
            return 1;
        }

        if (empty($password) || strlen($password) < 6) {
            $this->error('Пароль должен содержать минимум 6 символов!');
            return 1;
        }

        // Проверяем, существует ли пользователь с таким логином
        if (User::where('pole', $pole)->exists()) {
            $this->error('Пользователь с таким логином уже существует!');
            return 1;
        }

        // Создаем администратора
        try {
            $admin = User::create([
                'name' => $name,
                'pole' => $pole,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->info("✅ Администратор успешно создан!");
            $this->info("   Имя: {$admin->name}");
            $this->info("   Логин: {$admin->pole}");
            $this->info("   Роль: {$admin->role}");
            $this->newLine();
            $this->comment("Теперь вы можете войти в систему с этими данными.");

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Ошибка при создании администратора: " . $e->getMessage());
            return 1;
        }
    }
}
