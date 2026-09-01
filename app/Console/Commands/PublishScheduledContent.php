<?php

namespace App\Console\Commands;

use App\Models\Agreement;
use App\Models\CallForProposal;
use App\Models\Document;
use App\Models\Event;
use App\Models\MobilityOpportunity;
use App\Models\News;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Researchteam;
use App\Models\SchoolPresentation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

/**
 * REQ-10 (scheduled publishing) + REQ-11 (agreement expiry): scheduledAt
 * exists on every publishable content type but nothing ever flips
 * scheduled -> published once the date arrives, and Agreement.status
 * never flips active -> expired once endDate passes. This command does
 * both. Registered on the scheduler (routes/console.php) AND triggered
 * opportunistically by EnsureScheduledContentPublished middleware so it
 * self-heals even on a machine with no cron/scheduler running (e.g. a
 * local dev box).
 */
class PublishScheduledContent extends Command
{
    protected $signature = 'content:publish-scheduled';
    protected $description = 'Publish content whose scheduledAt has arrived and expire agreements past endDate.';

    /** @var class-string[] */
    private array $publishableModels = [
        Agreement::class,
        CallForProposal::class,
        Document::class,
        Event::class,
        MobilityOpportunity::class,
        News::class,
        Partner::class,
        Project::class,
        Researchteam::class,
        SchoolPresentation::class,
    ];

    public function handle(): int
    {
        $now = Carbon::now();
        $publishedTotal = 0;

        foreach ($this->publishableModels as $model) {
            $instance = new $model();
            $table = $instance->getTable();

            if (! Schema::hasColumn($table, 'publicationStatus') || ! Schema::hasColumn($table, 'scheduledAt') || ! Schema::hasColumn($table, 'publishedAt')) {
                continue;
            }

            $count = $model::query()
                ->where('publicationStatus', 'scheduled')
                ->whereNotNull('scheduledAt')
                ->where('scheduledAt', '<=', $now)
                ->update([
                    'publicationStatus' => 'published',
                    'publishedAt' => $now,
                ]);

            $publishedTotal += $count;
        }

        if (Schema::hasColumn('Agreement', 'status') && Schema::hasColumn('Agreement', 'endDate')) {
            $expired = Agreement::query()
                ->where('status', 'active')
                ->whereNotNull('endDate')
                ->whereDate('endDate', '<', $now->toDateString())
                ->update(['status' => 'expired']);
        } else {
            $expired = 0;
        }

        $this->info("Published {$publishedTotal} scheduled item(s). Expired {$expired} agreement(s).");

        return self::SUCCESS;
    }
}