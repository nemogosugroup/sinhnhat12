<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Models\DataLog;
use App\Models\User;
use App\Repositories\Game2048\game2048Repository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class IncreaseMochi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mochi:increase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase mochi value for all users every 2 hours from 8 AM to 6 PM';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $now = now();
        if ($now->between('8:00', '18:30')) {
            User::chunk(100, function ($users) {
                foreach ($users as $user) {
                    $user->point_mochi += 10;
                    $user->save();
                    // save log
                    DataLog::query()->create([
                        'user_id' => $user->id,
                        'type' => EVENT_BIRTHDAY12['type']['mochi'],
                        'action' => EVENT_BIRTHDAY12['action']['plus'],
                        'points' => 10,
                        'date_number' => app(Helpers::class)->getCurrentDateNumber(),
                        'content' => "Tự động hồi 10 <b style='color: #317489'>Mochi</b> sau mỗi 2 tiếng, từ 8h đến 18h" // TODO: change content
                    ]);
                }
            });

            $this->info('Mochi values have been increased successfully.');
        } else {
            $this->info('It\'s not time to increase mochi values yet.');
        }

        return CommandAlias::SUCCESS;
    }
}