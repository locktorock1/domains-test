<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Log;
use App\Services\DomainCheckerService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('domains:check')]
#[Description('Check all domains status')]
class CheckDomainsCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(DomainCheckerService $checker)
    {
        $domains = Domain::all();

        foreach ($domains as $domain) {

            $result = $checker->check($domain);

            Log::create([
                'domain_id' => $domain->id,
                'response_result' => $result['reachable'] ?? false,
                'response_code' => $result['status'],
                'response_time' => $result['time_ms'] ?? null,
            ]);
        }

        $this->info('Domains checked successfully');
    }
}
