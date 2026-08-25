<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Seeds Region/RegionTranslation and Country/CountryTranslation
     * with all 194 UN member states, translated in en/fr/ar.
     * Idempotent: safe to run even if some rows already exist
     * (e.g. Spain / Europe already present).
     * Source: mledoze/countries (ISO 3166 + continent + translations).
     */
    public function run(): void
    {
        // --- Regions (continents) -------------------------------------------------
        $regionNames = [
            'Africa' => ['en' => 'Africa', 'fr' => 'Africa', 'ar' => 'Africa'],
            'Americas' => ['en' => 'Americas', 'fr' => 'Americas', 'ar' => 'Americas'],
            'Asia' => ['en' => 'Asia', 'fr' => 'Asia', 'ar' => 'Asia'],
            'Europe' => ['en' => 'Europe', 'fr' => 'Europe', 'ar' => 'Europe'],
            'Oceania' => ['en' => 'Oceania', 'fr' => 'Oceania', 'ar' => 'Oceania'],
        ];

        $regionIDs = [];
        foreach ($regionNames as $regionKey => $translations) {
            // Reuse an existing region if one already has this English name
            $existingID = DB::table('RegionTranslation')
                ->where('languageCode', 'en')
                ->where('regionName', $translations['en'])
                ->value('regionID');

            if ($existingID) {
                $regionIDs[$regionKey] = $existingID;
                continue;
            }

            $regionID = DB::table('Region')->insertGetId([]);
            $regionIDs[$regionKey] = $regionID;
            foreach ($translations as $lang => $name) {
                DB::table('RegionTranslation')->insert([
                    'regionID'     => $regionID,
                    'languageCode' => $lang,
                    'regionName'   => $name,
                ]);
            }
        }

        // --- Countries ---------------------------------------------------------
        // [countryCode(ISO2), region, en, fr, ar]
        $countries = [
            ['AF', 'Asia', 'Afghanistan', 'Afghanistan', 'أفغانستان'],
            ['AL', 'Europe', 'Albania', 'Albanie', 'ألبانيا'],
            ['DZ', 'Africa', 'Algeria', 'Algérie', 'الجزائر'],
            ['AD', 'Europe', 'Andorra', 'Andorre', 'أندورا'],
            ['AO', 'Africa', 'Angola', 'Angola', 'جمهورية أنغولا'],
            ['AG', 'Americas', 'Antigua and Barbuda', 'Antigua-et-Barbuda', 'أنتيغوا وباربودا'],
            ['AR', 'Americas', 'Argentina', 'Argentine', 'الأرجنتين'],
            ['AM', 'Asia', 'Armenia', 'Arménie', 'أرمينيا'],
            ['AU', 'Oceania', 'Australia', 'Australie', 'أستراليا'],
            ['AT', 'Europe', 'Austria', 'Autriche', 'النمسا'],
            ['AZ', 'Asia', 'Azerbaijan', 'Azerbaïdjan', 'أذربيجان'],
            ['BS', 'Americas', 'Bahamas', 'Bahamas', 'البهاما'],
            ['BH', 'Asia', 'Bahrain', 'Bahreïn', 'البحرين'],
            ['BD', 'Asia', 'Bangladesh', 'Bangladesh', 'بنغلاديش'],
            ['BB', 'Americas', 'Barbados', 'Barbade', 'باربادوس'],
            ['BY', 'Europe', 'Belarus', 'Biélorussie', 'بيلاروسيا'],
            ['BE', 'Europe', 'Belgium', 'Belgique', 'بلجيكا'],
            ['BZ', 'Americas', 'Belize', 'Belize', 'بليز'],
            ['BJ', 'Africa', 'Benin', 'Bénin', 'بنين'],
            ['BT', 'Asia', 'Bhutan', 'Bhoutan', 'بوتان'],
            ['BO', 'Americas', 'Bolivia', 'Bolivie', 'بوليفيا'],
            ['BA', 'Europe', 'Bosnia and Herzegovina', 'Bosnie-Herzégovine', 'البوسنة والهرسك'],
            ['BW', 'Africa', 'Botswana', 'Botswana', 'بوتسوانا'],
            ['BR', 'Americas', 'Brazil', 'Brésil', 'البرازيل'],
            ['BN', 'Asia', 'Brunei', 'Brunei', 'بروناي'],
            ['BG', 'Europe', 'Bulgaria', 'Bulgarie', 'بلغاريا'],
            ['BF', 'Africa', 'Burkina Faso', 'Burkina Faso', 'بوركينا فاسو'],
            ['BI', 'Africa', 'Burundi', 'Burundi', 'بوروندي'],
            ['KH', 'Asia', 'Cambodia', 'Cambodge', 'كمبوديا'],
            ['CM', 'Africa', 'Cameroon', 'Cameroun', 'الكاميرون'],
            ['CA', 'Americas', 'Canada', 'Canada', 'كندا'],
            ['CV', 'Africa', 'Cape Verde', 'Îles du Cap-Vert', 'كابو فيردي'],
            ['CF', 'Africa', 'Central African Republic', 'République centrafricaine', 'جمهورية أفريقيا الوسطى'],
            ['TD', 'Africa', 'Chad', 'Tchad', 'تشاد'],
            ['CL', 'Americas', 'Chile', 'Chili', 'تشيلي'],
            ['CN', 'Asia', 'China', 'Chine', 'الصين'],
            ['CO', 'Americas', 'Colombia', 'Colombie', 'كولومبيا'],
            ['KM', 'Africa', 'Comoros', 'Comores', 'جزر القمر'],
            ['CG', 'Africa', 'Congo', 'Congo', 'جمهورية الكونغو'],
            ['CR', 'Americas', 'Costa Rica', 'Costa Rica', 'كوستاريكا'],
            ['HR', 'Europe', 'Croatia', 'Croatie', 'كرواتيا'],
            ['CU', 'Americas', 'Cuba', 'Cuba', 'كوبا'],
            ['CY', 'Europe', 'Cyprus', 'Chypre', 'قبرص'],
            ['CZ', 'Europe', 'Czechia', 'Tchéquie', 'التشيك'],
            ['CD', 'Africa', 'DR Congo', 'Congo (Rép. dém.)', 'الكونغو'],
            ['DK', 'Europe', 'Denmark', 'Danemark', 'الدنمارك'],
            ['DJ', 'Africa', 'Djibouti', 'Djibouti', 'جيبوتي'],
            ['DM', 'Americas', 'Dominica', 'Dominique', 'دومينيكا'],
            ['DO', 'Americas', 'Dominican Republic', 'République dominicaine', 'جمهورية الدومينيكان'],
            ['EC', 'Americas', 'Ecuador', 'Équateur', 'الإكوادور'],
            ['EG', 'Africa', 'Egypt', 'Égypte', 'مصر'],
            ['SV', 'Americas', 'El Salvador', 'Salvador', 'السلفادور'],
            ['GQ', 'Africa', 'Equatorial Guinea', 'Guinée équatoriale', 'غينيا الاستوائية'],
            ['ER', 'Africa', 'Eritrea', 'Érythrée', 'إريتريا'],
            ['EE', 'Europe', 'Estonia', 'Estonie', 'إستونيا'],
            ['SZ', 'Africa', 'Eswatini', 'Eswatini', 'إسواتيني'],
            ['ET', 'Africa', 'Ethiopia', 'Éthiopie', 'إثيوبيا'],
            ['FJ', 'Oceania', 'Fiji', 'Fidji', 'فيجي'],
            ['FI', 'Europe', 'Finland', 'Finlande', 'فنلندا'],
            ['FR', 'Europe', 'France', 'France', 'فرنسا'],
            ['GA', 'Africa', 'Gabon', 'Gabon', 'الغابون'],
            ['GM', 'Africa', 'Gambia', 'Gambie', 'غامبيا'],
            ['GE', 'Asia', 'Georgia', 'Géorgie', 'جورجيا'],
            ['DE', 'Europe', 'Germany', 'Allemagne', 'ألمانيا'],
            ['GH', 'Africa', 'Ghana', 'Ghana', 'غانا'],
            ['GR', 'Europe', 'Greece', 'Grèce', 'اليونان'],
            ['GD', 'Americas', 'Grenada', 'Grenade', 'غرينادا'],
            ['GT', 'Americas', 'Guatemala', 'Guatemala', 'غواتيمالا'],
            ['GN', 'Africa', 'Guinea', 'Guinée', 'غينيا'],
            ['GW', 'Africa', 'Guinea-Bissau', 'Guinée-Bissau', 'غينيا بيساو'],
            ['GY', 'Americas', 'Guyana', 'Guyana', 'غيانا'],
            ['HT', 'Americas', 'Haiti', 'Haïti', 'هايتي'],
            ['HN', 'Americas', 'Honduras', 'Honduras', 'هندوراس'],
            ['HU', 'Europe', 'Hungary', 'Hongrie', 'المجر'],
            ['IS', 'Europe', 'Iceland', 'Islande', 'آيسلندا'],
            ['IN', 'Asia', 'India', 'Inde', 'الهند'],
            ['ID', 'Asia', 'Indonesia', 'Indonésie', 'إندونيسيا'],
            ['IR', 'Asia', 'Iran', 'Iran', 'إيران'],
            ['IQ', 'Asia', 'Iraq', 'Irak', 'العراق'],
            ['IE', 'Europe', 'Ireland', 'Irlande', 'أيرلندا'],
            ['IL', 'Asia', 'Israel', 'Israël', 'إسرائيل'],
            ['IT', 'Europe', 'Italy', 'Italie', 'إيطاليا'],
            ['CI', 'Africa', 'Ivory Coast', 'Côte d\'Ivoire', 'ساحل العاج'],
            ['JM', 'Americas', 'Jamaica', 'Jamaïque', 'جامايكا'],
            ['JP', 'Asia', 'Japan', 'Japon', 'اليابان'],
            ['JO', 'Asia', 'Jordan', 'Jordanie', 'الأردن'],
            ['KZ', 'Asia', 'Kazakhstan', 'Kazakhstan', 'كازاخستان'],
            ['KE', 'Africa', 'Kenya', 'Kenya', 'كينيا'],
            ['KI', 'Oceania', 'Kiribati', 'Kiribati', 'كيريباتي'],
            ['KW', 'Asia', 'Kuwait', 'Koweït', 'الكويت'],
            ['KG', 'Asia', 'Kyrgyzstan', 'Kirghizistan', 'قيرغيزستان'],
            ['LA', 'Asia', 'Laos', 'Laos', 'لاوس'],
            ['LV', 'Europe', 'Latvia', 'Lettonie', 'لاتفيا'],
            ['LB', 'Asia', 'Lebanon', 'Liban', 'لبنان'],
            ['LS', 'Africa', 'Lesotho', 'Lesotho', 'ليسوتو'],
            ['LR', 'Africa', 'Liberia', 'Liberia', 'ليبيريا'],
            ['LY', 'Africa', 'Libya', 'Libye', 'ليبيا'],
            ['LI', 'Europe', 'Liechtenstein', 'Liechtenstein', 'ليختنشتاين'],
            ['LT', 'Europe', 'Lithuania', 'Lituanie', 'ليتوانيا'],
            ['LU', 'Europe', 'Luxembourg', 'Luxembourg', 'لوكسمبورغ'],
            ['MG', 'Africa', 'Madagascar', 'Madagascar', 'مدغشقر'],
            ['MW', 'Africa', 'Malawi', 'Malawi', 'مالاوي'],
            ['MY', 'Asia', 'Malaysia', 'Malaisie', 'ماليزيا'],
            ['MV', 'Asia', 'Maldives', 'Maldives', 'المالديف'],
            ['ML', 'Africa', 'Mali', 'Mali', 'مالي'],
            ['MT', 'Europe', 'Malta', 'Malte', 'مالطا'],
            ['MH', 'Oceania', 'Marshall Islands', 'Îles Marshall', 'جزر مارشال'],
            ['MR', 'Africa', 'Mauritania', 'Mauritanie', 'موريتانيا'],
            ['MU', 'Africa', 'Mauritius', 'Île Maurice', 'موريشيوس'],
            ['MX', 'Americas', 'Mexico', 'Mexique', 'المسكيك'],
            ['FM', 'Oceania', 'Micronesia', 'Micronésie', 'ميكرونيسيا'],
            ['MD', 'Europe', 'Moldova', 'Moldavie', 'مولدوڤا'],
            ['MC', 'Europe', 'Monaco', 'Monaco', 'موناكو'],
            ['MN', 'Asia', 'Mongolia', 'Mongolie', 'منغوليا'],
            ['ME', 'Europe', 'Montenegro', 'Monténégro', 'الجبل الاسود'],
            ['MA', 'Africa', 'Morocco', 'Maroc', 'المغرب'],
            ['MZ', 'Africa', 'Mozambique', 'Mozambique', 'موزمبيق'],
            ['MM', 'Asia', 'Myanmar', 'Birmanie', 'ميانمار'],
            ['NA', 'Africa', 'Namibia', 'Namibie', 'ناميبيا'],
            ['NR', 'Oceania', 'Nauru', 'Nauru', 'ناورو'],
            ['NP', 'Asia', 'Nepal', 'Népal', 'نيبال'],
            ['NL', 'Europe', 'Netherlands', 'Pays-Bas', 'هولندا'],
            ['NZ', 'Oceania', 'New Zealand', 'Nouvelle-Zélande', 'نيوزيلندا'],
            ['NI', 'Americas', 'Nicaragua', 'Nicaragua', 'نيكاراغوا'],
            ['NE', 'Africa', 'Niger', 'Niger', 'النيجر'],
            ['NG', 'Africa', 'Nigeria', 'Nigéria', 'نيجيريا'],
            ['KP', 'Asia', 'North Korea', 'Corée du Nord', 'كوريا الشمالية'],
            ['MK', 'Europe', 'North Macedonia', 'Macédoine du Nord', 'شمال مقدونيا'],
            ['NO', 'Europe', 'Norway', 'Norvège', 'النرويج'],
            ['OM', 'Asia', 'Oman', 'Oman', 'عمان'],
            ['PK', 'Asia', 'Pakistan', 'Pakistan', 'باكستان'],
            ['PW', 'Oceania', 'Palau', 'Palaos (Palau)', 'بالاو'],
            ['PA', 'Americas', 'Panama', 'Panama', 'بنما'],
            ['PG', 'Oceania', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinée', 'بابوا غينيا الجديدة'],
            ['PY', 'Americas', 'Paraguay', 'Paraguay', 'باراغواي'],
            ['PE', 'Americas', 'Peru', 'Pérou', 'بيرو'],
            ['PH', 'Asia', 'Philippines', 'Philippines', 'الفلبين'],
            ['PL', 'Europe', 'Poland', 'Pologne', 'بولندا'],
            ['PT', 'Europe', 'Portugal', 'Portugal', 'البرتغال'],
            ['QA', 'Asia', 'Qatar', 'Qatar', 'قطر'],
            ['RO', 'Europe', 'Romania', 'Roumanie', 'رومانيا'],
            ['RU', 'Europe', 'Russia', 'Russie', 'روسيا'],
            ['RW', 'Africa', 'Rwanda', 'Rwanda', 'رواندا'],
            ['KN', 'Americas', 'Saint Kitts and Nevis', 'Saint-Christophe-et-Niévès', 'سانت كيتس ونيفيس'],
            ['LC', 'Americas', 'Saint Lucia', 'Sainte-Lucie', 'سانت لوسيا'],
            ['VC', 'Americas', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les-Grenadines', 'سانت فينسنت والغرينادين'],
            ['WS', 'Oceania', 'Samoa', 'Samoa', 'ساموا'],
            ['SM', 'Europe', 'San Marino', 'Saint-Marin', 'سان مارينو'],
            ['SA', 'Asia', 'Saudi Arabia', 'Arabie Saoudite', 'السعودية'],
            ['SN', 'Africa', 'Senegal', 'Sénégal', 'السنغال'],
            ['RS', 'Europe', 'Serbia', 'Serbie', 'صيربيا'],
            ['SC', 'Africa', 'Seychelles', 'Seychelles', 'سيشل'],
            ['SL', 'Africa', 'Sierra Leone', 'Sierra Leone', 'سيراليون'],
            ['SG', 'Asia', 'Singapore', 'Singapour', 'سنغافورة'],
            ['SK', 'Europe', 'Slovakia', 'Slovaquie', 'سلوفاكيا'],
            ['SI', 'Europe', 'Slovenia', 'Slovénie', 'سلوفينيا'],
            ['SB', 'Oceania', 'Solomon Islands', 'Îles Salomon', 'جزر سليمان'],
            ['SO', 'Africa', 'Somalia', 'Somalie', 'الصومال'],
            ['ZA', 'Africa', 'South Africa', 'Afrique du Sud', 'جنوب أفريقيا'],
            ['KR', 'Asia', 'South Korea', 'Corée du Sud', 'كوريا الجنوبية'],
            ['SS', 'Africa', 'South Sudan', 'Soudan du Sud', 'جنوب السودان'],
            ['ES', 'Europe', 'Spain', 'Espagne', 'إسبانيا'],
            ['LK', 'Asia', 'Sri Lanka', 'Sri Lanka', 'سريلانكا'],
            ['SD', 'Africa', 'Sudan', 'Soudan', 'السودان'],
            ['SR', 'Americas', 'Suriname', 'Surinam', 'سورينام'],
            ['SE', 'Europe', 'Sweden', 'Suède', 'السويد'],
            ['CH', 'Europe', 'Switzerland', 'Suisse', 'سويسرا'],
            ['SY', 'Asia', 'Syria', 'Syrie', 'سوريا'],
            ['ST', 'Africa', 'São Tomé and Príncipe', 'São Tomé et Príncipe', 'ساو تومي وبرينسيب'],
            ['TJ', 'Asia', 'Tajikistan', 'Tadjikistan', 'طاجيكستان'],
            ['TZ', 'Africa', 'Tanzania', 'Tanzanie', 'تنزانيا'],
            ['TH', 'Asia', 'Thailand', 'Thaïlande', 'تايلند'],
            ['TL', 'Asia', 'Timor-Leste', 'Timor oriental', 'تيمور الشرقية'],
            ['TG', 'Africa', 'Togo', 'Togo', 'توغو'],
            ['TO', 'Oceania', 'Tonga', 'Tonga', 'تونغا'],
            ['TT', 'Americas', 'Trinidad and Tobago', 'Trinité-et-Tobago', 'ترينيداد وتوباغو'],
            ['TN', 'Africa', 'Tunisia', 'Tunisie', 'تونس'],
            ['TM', 'Asia', 'Turkmenistan', 'Turkménistan', 'تركمانستان'],
            ['TV', 'Oceania', 'Tuvalu', 'Tuvalu', 'توفالو'],
            ['TR', 'Asia', 'Türkiye', 'Turquie', 'تركيا'],
            ['UG', 'Africa', 'Uganda', 'Ouganda', 'أوغندا'],
            ['UA', 'Europe', 'Ukraine', 'Ukraine', 'أوكرانيا'],
            ['AE', 'Asia', 'United Arab Emirates', 'Émirats arabes unis', 'الإمارات'],
            ['GB', 'Europe', 'United Kingdom', 'Royaume-Uni', 'المملكة المتحدة'],
            ['US', 'Americas', 'United States', 'États-Unis', 'الولايات المتحدة'],
            ['UY', 'Americas', 'Uruguay', 'Uruguay', 'الأوروغواي'],
            ['UZ', 'Asia', 'Uzbekistan', 'Ouzbékistan', 'أوزباكستان'],
            ['VU', 'Oceania', 'Vanuatu', 'Vanuatu', 'فانواتو'],
            ['VA', 'Europe', 'Vatican City', 'Cité du Vatican', 'مدينة الفاتيكان'],
            ['VE', 'Americas', 'Venezuela', 'Venezuela', 'فنزويلا'],
            ['VN', 'Asia', 'Vietnam', 'Viêt Nam', 'فيتنام'],
            ['YE', 'Asia', 'Yemen', 'Yémen', 'اليمن'],
            ['ZM', 'Africa', 'Zambia', 'Zambie', 'زامبيا'],
            ['ZW', 'Africa', 'Zimbabwe', 'Zimbabwe', 'زيمبابوي'],
        ];

        foreach ($countries as [$code, $region, $en, $fr, $ar]) {
            // Skip if this country already exists (e.g. Spain, already seeded manually)
            if (DB::table('Country')->where('countryCode', $code)->exists()) {
                continue;
            }

            DB::table('Country')->insert([
                'countryCode' => $code,
                'regionID'    => $regionIDs[$region],
            ]);

            DB::table('CountryTranslation')->insert([
                ['countryCode' => $code, 'languageCode' => 'en', 'countryName' => $en],
                ['countryCode' => $code, 'languageCode' => 'fr', 'countryName' => $fr],
                ['countryCode' => $code, 'languageCode' => 'ar', 'countryName' => $ar],
            ]);
        }
    }
}