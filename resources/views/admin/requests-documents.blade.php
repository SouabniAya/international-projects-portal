@extends('layouts.admin')

@section('title', __('Requests & Documents Management'))

@section('content')
<div class="reqdocs-page">

    <div class="reqdocs-page__head">
        <h1>{{ __('Requests & Documents Management') }}</h1>
        <p>{{ __('Manage incoming requests and the document library in one centralized place.') }}</p>
    </div>

    {{-- Contact Requests --}}
    <section class="reqdocs-panel">
        <div class="reqdocs-panel__head">
            <h2>{{ __('Contact Requests') }}</h2>
            <a href="#" class="reqdocs-panel__view-all">
                {{ __('View All') }}
            </a>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">
                <thead>
                    <tr>
                        <th>{{ __('Requester') }}</th>
                        <th>{{ __('Subject') }}</th>
                        <th>{{ __('Reason') }}</th>
                        <th>{{ __('Submitted On') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Assigned To') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $contactRequests = collect(range(1, 3))->map(fn() => [
                            'name' => 'Mohamed Salah',
                            'email' => 'm.salah@email.com',
                            'subject' => 'Information about funding opportunities',
                            'reason' => 'Request for information',
                            'date' => '15 May 2024 10:23 AM',
                            'status' => 'New',
                            'assigned' => 'Unassigned',
                        ]);
                    @endphp

                    @foreach($contactRequests as $r)
                        <tr>
                            <td>
                                <div class="reqdocs-table__requester">
                                    <span class="reqdocs-table__dot"></span>

                                    <div>
                                        <strong>{{ $r['name'] }}</strong>
                                        <span>{{ $r['email'] }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>{{ __($r['subject']) }}</td>
                            <td>{{ __($r['reason']) }}</td>
                            <td>{{ $r['date'] }}</td>

                            <td>
                                <span class="reqdocs-table__status reqdocs-table__status--new">
                                    {{ __($r['status']) }}
                                </span>
                            </td>

                            <td>
                                <span class="reqdocs-table__unassigned">
                                    {{ __($r['assigned']) }}
                                </span>
                            </td>

                            <td>
                                <div class="reqdocs-table__actions">

                                    <button
                                        type="button"
                                        aria-label="{{ __('Assign') }}"
                                        title="{{ __('Assign') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <circle
                                                cx="12"
                                                cy="8"
                                                r="3.4"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                            <path
                                                d="M5 20c0-3.6 3.1-5.6 7-5.6s7 2 7 5.6"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        aria-label="{{ __('View') }}"
                                        title="{{ __('View') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>


    {{-- Partnership Requests --}}
    <section class="reqdocs-panel">

        <div class="reqdocs-panel__head">
            <h2>{{ __('Partnership Requests') }}</h2>

            <a href="#" class="reqdocs-panel__view-all">
                {{ __('View All') }}
            </a>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">

                <thead>
                    <tr>
                        <th>{{ __('Requester') }}</th>
                        <th>{{ __('Organization') }}</th>
                        <th>{{ __('Country') }}</th>
                        <th>{{ __('Contact') }}</th>
                        <th>{{ __('Documents') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Assigned to') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $partnerRequests = collect(range(1, 3))->map(fn() => [
                            'name' => 'Nadia H.',
                            'email' => 'nadia.h@eust.edu',
                            'org' => 'European University of Science',
                            'country_flag' => 'images/flags/fr.png',
                            'phone' => '+33 1 23 45 67 89',
                            'docs' => 2,
                            'status' => 'Pending',
                            'assigned' => 'Unassigned',
                        ]);
                    @endphp

                    @foreach($partnerRequests as $r)
                        <tr>

                            <td>
                                <div class="reqdocs-table__requester">
                                    <span class="reqdocs-table__dot"></span>

                                    <div>
                                        <strong>{{ $r['name'] }}</strong>
                                        <span>{{ $r['email'] }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $r['org'] }}</td>

                            <td>
                                <img
                                    src="{{ asset($r['country_flag']) }}"
                                    alt="{{ __('Country') }}"
                                    class="reqdocs-table__flag"
                                >
                            </td>

                            <td>{{ $r['phone'] }}</td>

                            <td class="reqdocs-table__center">
                                {{ $r['docs'] }}
                            </td>

                            <td>
                                <span class="reqdocs-table__status reqdocs-table__status--pending">
                                    {{ __($r['status']) }}
                                </span>
                            </td>

                            <td>
                                <span class="reqdocs-table__unassigned">
                                    {{ __($r['assigned']) }}
                                </span>
                            </td>

                            <td>
                                <div class="reqdocs-table__actions">

                                    <button
                                        type="button"
                                        class="reqdocs-table__icon-btn reqdocs-table__icon-btn--approve"
                                        aria-label="{{ __('Approve') }}"
                                        title="{{ __('Approve') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M5 13l4 4 10-10"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="reqdocs-table__icon-btn reqdocs-table__icon-btn--reject"
                                        aria-label="{{ __('Reject') }}"
                                        title="{{ __('Reject') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M6 6l12 12M18 6L6 18"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        aria-label="{{ __('View') }}"
                                        title="{{ __('View') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                        </svg>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </section>


    {{-- Document Library --}}
    <section class="reqdocs-panel">

        <div class="reqdocs-panel__head">

            <h2>{{ __('Document Library') }}</h2>

            <button type="button" class="reqdocs-panel__add">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M12 5v14M5 12h14"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

                {{ __('Add Document') }}
            </button>

        </div>

        <div class="reqdocs-table-wrap">

            <table class="reqdocs-table">

                <thead>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Publication Date') }}</th>
                        <th>{{ __('Visibility') }}</th>
                        <th>{{ __('File / Link') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $documents = [
                            [
                                'title' => 'Guide to Horizon Europe Programme',
                                'category' => 'Funding Programmes',
                                'date' => '10 Apr 2024',
                                'visibility' => 'Public',
                                'size' => '2.3 MB'
                            ],
                        ];
                    @endphp

                    @foreach($documents as $doc)

                        <tr>

                            <td>
                                <div class="reqdocs-table__doc">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="reqdocs-table__doc-icon"
                                    >
                                        <path
                                            d="M6 2h9l5 5v15H6V2Z"
                                            stroke="currentColor"
                                            stroke-width="1.4"
                                            stroke-linejoin="round"
                                            fill="#FDEBEC"
                                        />
                                        <path
                                            d="M15 2v5h5"
                                            stroke="currentColor"
                                            stroke-width="1.4"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                    <span>{{ __($doc['title']) }}</span>

                                </div>
                            </td>

                            <td>{{ __($doc['category']) }}</td>

                            <td>{{ $doc['date'] }}</td>

                            <td>{{ __($doc['visibility']) }}</td>

                            <td>
                                <a href="#" class="reqdocs-table__filelink">
                                    PDF ({{ $doc['size'] }})
                                </a>
                            </td>

                            <td>

                                <div class="reqdocs-table__actions">

                                    <button
                                        type="button"
                                        aria-label="{{ __('Download') }}"
                                        title="{{ __('Download') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        aria-label="{{ __('Edit') }}"
                                        title="{{ __('Edit') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M4 20l1-4L16 5l3 3L8 19l-4 1Z"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        aria-label="{{ __('More') }}"
                                        title="{{ __('More') }}"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <circle cx="5" cy="12" r="1.4" fill="currentColor"/>
                                            <circle cx="12" cy="12" r="1.4" fill="currentColor"/>
                                            <circle cx="19" cy="12" r="1.4" fill="currentColor"/>
                                        </svg>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </section>

</div>
@endsection