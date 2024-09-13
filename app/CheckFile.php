<?php

namespace App;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //get file
        try {
            $results = Http::get("URL");
            //send content to class
            $results = (new FileValidator())->handle($results->body());

            if(!$results) {
                Notification::route("slack", env("SLACK_WEBHOOK_URL"))->notify(
                    new SlackNotification()
                );
            }

            Log::info("File validated ran");
        } catch (\Exception $e) {
            Log::error("File validation failed", [
                'exception' => $e,
            ]);
        }
    }
}
