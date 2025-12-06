<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-role {pole} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Установить роль пользователю по логину (pole). Роли: patient, doctor, admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pole = $this->argument('pole');
        $role = $this->argument('role');

        // Валидация роли
        $allowedRoles = ['patient', 'doctor', 'admin'];
        if (!in_array($role, $allowedRoles)) {
            $this->error("❌ Неверная роль! Доступные роли: " . implode(', ', $allowedRoles));
            return 1;
        }

        // Находим пользователя
        $user = User::where('pole', $pole)->first();

        if (!$user) {
            $this->error("❌ Пользователь с логином '{$pole}' не найден!");
            return 1;
        }

        // Обновляем роль
        try {
            $oldRole = $user->role;
            $user->role = $role;
            $user->save();

            $this->info("✅ Роль успешно обновлена!");
            $this->info("   Пользователь: {$user->name} (логин: {$user->pole})");
            $this->info("   Старая роль: {$oldRole}");
            $this->info("   Новая роль: {$role}");

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Ошибка при обновлении роли: " . $e->getMessage());
            return 1;
        }
    }
}
