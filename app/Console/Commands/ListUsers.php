<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Показать список всех пользователей с их ролями';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->info('Пользователи не найдены.');
            return 0;
        }

        $this->info('Список пользователей:');
        $this->newLine();

        $headers = ['ID', 'Имя', 'Логин (pole)', 'Роль', 'Дата регистрации'];
        $rows = [];

        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->pole,
                $user->role ?? 'не установлена',
                $user->created_at->format('d.m.Y H:i'),
            ];
        }

        $this->table($headers, $rows);
        $this->newLine();
        $this->info("Всего пользователей: " . $users->count());

        return 0;
    }
}
