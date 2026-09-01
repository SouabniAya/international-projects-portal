<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

function typeLabel(?string $type): string
{
    $labels = [
        'outgoing_student' => 'Outgoing Student Mobility',
        'incoming_student' => 'Incoming Student Mobility',
        'staff' => 'Staff Mobility',
        'researcher' => 'Researcher Mobility',
        'internship' => 'Internship',
        'summer_school' => 'Summer School',
        'scientific_stay' => 'Scientific Stay',
        'scholarship' => 'Scholarship',
    ];

    return $labels[$type] ?? 'Mobility Opportunity';
}

if (! Schema::hasTable('MobilityOpportunityTranslation')) {
    throw new RuntimeException('MobilityOpportunityTranslation table not found.');
}

if (! Schema::hasColumn('MobilityOpportunityTranslation', 'title')) {
    Schema::table('MobilityOpportunityTranslation', function (Blueprint $table) {
        $table->string('title')->nullable()->after('languageCode');
    });
}

$programme = DB::table('FundingProgramme')->first();
$country = DB::table('Country')->first();
$partner = DB::table('Partner')->first();

if (! $programme) {
    throw new RuntimeException('No FundingProgramme records found.');
}
if (! $country) {
    throw new RuntimeException('No Country records found.');
}
if (! $partner) {
    throw new RuntimeException('No Partner records found.');
}

$mobilityId = DB::table('MobilityOpportunity')->insertGetId([
    'hostingEstablishment' => $partner->name ?? 'ESI Partner University',
    'city' => 'Brussels',
    'targetAudience' => 'Master and PhD students',
    'placesAvailable' => 12,
    'startDate' => '2026-09-15',
    'endDate' => '2027-02-15',
    'requiredLanguageSkills' => 'B2 English',
    'applicationDeadline' => '2026-08-25',
    'contact' => 'mobility@esi.eu',
    'fundingAvailable' => 'Erasmus+ funding',
    'applicationLink' => 'https://example.com/mobility-apply',
    'featured' => 1,
    'publicationStatus' => 'published',
    'programID' => $programme->programID,
    'countryCode' => $country->countryCode,
    'publishedByUserID' => null,
    'hostedByPartner' => $partner->partnerID,
    'mobilityType' => 'incoming_student',
]);

DB::table('MobilityOpportunityTranslation')->insert([
    'mobilityID' => $mobilityId,
    'languageCode' => 'en',
    'title' => 'Incoming Student Mobility at ' . ($partner->name ?? 'Partner University'),
    'conditions' => 'This opportunity supports international study and exchange mobility for eligible students.',
    'applicationProcess' => 'Submit a motivation letter, transcript of records, and institutional nomination before the deadline.',
    'selectionCriteria' => 'Academic performance, motivation, and language proficiency are considered.',
]);

$translations = DB::table('MobilityOpportunityTranslation')->get();
foreach ($translations as $translation) {
    $title = trim((string) ($translation->title ?? ''));
    if ($title !== '') {
        continue;
    }

    $mobility = DB::table('MobilityOpportunity')->where('mobilityID', $translation->mobilityID)->first();
    $fallbackType = typeLabel($mobility->mobilityType ?? null);
    $fallbackHost = $mobility->hostingEstablishment ?? '';
    $newTitle = $fallbackHost ? $fallbackType . ' – ' . $fallbackHost : $fallbackType;

    DB::table('MobilityOpportunityTranslation')
        ->where('translationID', $translation->translationID)
        ->update(['title' => $newTitle]);
}

echo "Created mobilityID={$mobilityId}\n";
echo "Completed missing translation titles.\n";
