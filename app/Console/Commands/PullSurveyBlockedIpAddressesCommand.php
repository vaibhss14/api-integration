<?php

namespace App\Console\Commands;

use App\Models\Survey;
use App\Models\SurveyBlockedIpAddress;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PullSurveyBlockedIpAddressesCommand extends Command
{
    protected $signature = 'survey-blocked-ip-addresses:pull';

    protected $description = 'Pull Survey Blocked IP Addresses';

    public function handle()
    {
        $processed = 0;
        $skipped = 0;

        $surveys = Survey::all();

        foreach ($surveys as $survey) {

            $this->info("Fetching Survey {$survey->survey_id}");

            try {

                $response = Http::acceptJson()
                    ->timeout(120)
                    ->retry(3, 3000, throw: false)
                    ->withHeaders([
                        'access-token' => trim(env('ACCESS_TOKEN')),
                    ])
                    ->get(
                        "https://stagingsupply.opinionest.com/api/v1/survey/survey-blocked-ip-address/{$survey->survey_id}"
                    );

            } catch (ConnectionException $e) {

                $this->warn("Timeout Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                $response->status() === 404 &&
                $response->json('result.Message') &&
                str_contains($response->json('result.Message'), 'No blocked IPs found')
            ) {

                $this->warn("No blocked IPs for Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            if (
                ! $response->successful() ||
                ! $response->json('result.Success')
            ) {

                $this->warn("Skipped Survey {$survey->survey_id}");

                $skipped++;

                continue;
            }

            $ips = $response->json('ipAddress');

            if (empty($ips)) {
                continue;
            }

            foreach ($ips as $ip) {

                SurveyBlockedIpAddress::updateOrCreate(

                    [
                        'survey_id' => $survey->survey_id,
                        'ip_address' => $ip,
                    ],

                    [
                        'update_timestamp' => ! empty($response->json('updateTimestamp'))
                                ? Carbon::parse($response->json('updateTimestamp'))
                                : null,
                    ]

                );
            }

            $processed++;
        }

        $this->newLine();

        $this->info('Survey Blocked IP Addresses imported successfully.');
        $this->info("Surveys processed: {$processed}");
        $this->warn("Surveys skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
