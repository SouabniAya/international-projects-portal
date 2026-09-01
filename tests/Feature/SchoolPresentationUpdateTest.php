<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\SchoolPresentationController;
use App\Models\SchoolPresentation;
use App\Models\SchoolPresentationTranslation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchoolPresentationUpdateTest extends TestCase
{
    public function test_update_coerces_empty_text_fields_to_empty_strings_instead_of_null(): void
    {
        Schema::create('Language', function (Blueprint $table) {
            $table->string('languageCode')->primary();
        });

        DB::table('Language')->insert(['languageCode' => 'en']);

        Schema::create('SchoolPresentation', function (Blueprint $table) {
            $table->increments('presentationID');
            $table->string('officeEmail')->nullable();
            $table->string('officePhone')->nullable();
        });

        Schema::create('SchoolPresentationTranslation', function (Blueprint $table) {
            $table->increments('translationID');
            $table->unsignedInteger('presentationID');
            $table->string('languageCode');
            $table->text('description')->nullable(false);
            $table->text('vision')->nullable();
            $table->text('internationalizationStrategy')->nullable();
            $table->text('missions')->nullable();
            $table->text('objectives')->nullable();
            $table->text('teachingResearchDomains')->nullable();
            $table->text('partnershipBenefits')->nullable();
            $table->text('academicCalendar')->nullable();
            $table->text('registrationProcedure')->nullable();
            $table->text('officeAddress')->nullable();
            $table->text('officeLocation')->nullable();
        });

        Schema::create('OfficeHours', function (Blueprint $table) {
            $table->increments('hoursID');
            $table->unsignedInteger('presentationID')->nullable();
        });

        Schema::create('OfficeHoursTranslation', function (Blueprint $table) {
            $table->increments('translationID');
            $table->unsignedInteger('hoursID');
            $table->string('languageCode');
            $table->text('hoursText')->nullable();
        });

        $presentation = SchoolPresentation::query()->firstOrCreate([]);

        SchoolPresentationTranslation::query()->create([
            'presentationID' => $presentation->presentationID,
            'languageCode' => 'en',
            'description' => 'existing description',
            'vision' => 'existing vision',
            'missions' => 'existing missions',
        ]);

        $request = Request::create('/admin/school-presentation', 'PUT', [
            'language' => 'en',
            'description' => '',
            'vision' => '',
            'internationalizationStrategy' => '',
            'missions' => '',
            'objectives' => '',
            'teachingResearchDomains' => '',
            'partnershipBenefits' => '',
            'academicCalendar' => '',
            'registrationProcedure' => '',
            'officeEmail' => 'office@example.com',
            'officePhone' => '123456',
            'officeAddress' => '',
            'officeLocation' => '',
            'officeHoursText' => '',
        ]);

        $response = (new SchoolPresentationController())->update($request);

        $this->assertEquals(302, $response->getStatusCode());

        $updated = SchoolPresentationTranslation::query()
            ->where('presentationID', $presentation->presentationID)
            ->where('languageCode', 'en')
            ->first();

        $this->assertNotNull($updated);
        $this->assertSame('', $updated->description);
        $this->assertSame('', $updated->vision);
        $this->assertSame('', $updated->missions);
    }
}
