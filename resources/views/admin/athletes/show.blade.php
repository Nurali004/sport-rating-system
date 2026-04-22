@extends('layouts.backend')
@section('title', 'Show Athlete')
@section('admin')
    <style>
        .bio-text {
            white-space: pre-wrap;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 14px;
            color: #6b7280;
            line-height: 1.7;
        }
    </style>
    <div style="padding: 1.5rem;">


        <div style="background: var(--bs-body-bg, #fff); border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; max-width: 820px; margin: 0 auto; box-shadow: 0 1px 4px rgba(0,0,0,.06);">

            {{-- Header: avatar + name + badges --}}
            <div style="background: #f9fafb; padding: 1.5rem; display: flex; align-items: center; gap: 16px; border-bottom: 1px solid #e5e7eb;">


                @if($athlete->photo)
                    <img src="{{ asset('images/athletes/' . $athlete->photo) }}"
                         alt="{{ $athlete->first_name }}"
                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #e5e7eb;">
                @else
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #dbeafe; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; color: #1d4ed8; flex-shrink: 0;">
                        {{ strtoupper(substr($athlete->first_name, 0, 1) . substr($athlete->last_name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <div style="font-size: 18px; font-weight: 600; color: #111827;">
                        {{ $athlete->first_name.' '.$athlete->last_name.' '.$athlete->middle_name }}
                    </div>
                    <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">
                        {{ $athlete->sport->name_uz }} &nbsp;·&nbsp; {{ $athlete->region->name_uz }}
                    </div>
                </div>
                <div style="margin-left: auto; display: flex; gap: 8px; flex-wrap: wrap;">
                    @if($athlete->is_national_team)
                        <span style="background: #dcfce7; color: #15803d; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 500;">National Team</span>
                    @endif
                    <span style="background: #f3f4f6; color: #374151; font-size: 12px; padding: 4px 10px; border-radius: 6px; border: 1px solid #e5e7eb;">
          Rank #{{ $athlete->rank_position }}
        </span>
                </div>
            </div>

            {{-- Medals + stats row --}}
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); border-bottom: 1px solid #e5e7eb;">
                <div style="padding: 1rem; text-align: center; border-right: 1px solid #e5e7eb;">
                    <div style="font-size: 22px; font-weight: 600; color: #111827;">{{ $athlete->rating_score }}</div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 3px;">Rating</div>
                </div>
                <div style="padding: 1rem; text-align: center; border-right: 1px solid #e5e7eb;">
                    <div style="font-size: 22px; font-weight: 600; color: #b45309;">{{ $athlete->gold_medals }} 🥇</div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 3px;">Gold</div>
                </div>
                <div style="padding: 1rem; text-align: center; border-right: 1px solid #e5e7eb;">
                    <div style="font-size: 22px; font-weight: 600; color: #6b7280;">{{ $athlete->silver_medals }} 🥈</div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 3px;">Silver</div>
                </div>
                <div style="padding: 1rem; text-align: center;">
                    <div style="font-size: 22px; font-weight: 600; color: #92400e;">{{ $athlete->bronze_medals }} 🥉</div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 3px;">Bronze</div>
                </div>
            </div>

            {{-- Profile photo section (to'liq o'lchamli rasm) --}}
            @if($photos)
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb;">

                    <div style="font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 10px;">
                        Photo
                    </div>

                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        @foreach($photos as $photo)
                            <img src="{{ asset('images/athletes/' . $photo) }}"
                                 alt=""
                                 style="width: 160px; height: 200px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb;">
                        @endforeach
                    </div>

                </div>
            @endif

            {{-- Two-column detail sections --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; border-bottom: 1px solid #e5e7eb;">
                <div style="padding: 1.25rem 1.5rem; border-right: 1px solid #e5e7eb;">
                    <div style="font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 12px;">Personal info</div>
                    @foreach([
                      ['Birth date', $athlete->birth_date],
                      ['Gender',     $athlete->gender],
                      ['Height',     $athlete->height.' cm'],
                      ['Weight',     $athlete->weight.' kg'],
                      ['Category',   $athlete->weight_category],
                    ] as [$label, $value])
                        <div style="display:flex; justify-content:space-between; font-size:14px; padding: 7px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color:#6b7280;">{{ $label }}</span>
                            <span style="color:#111827; font-weight:500;">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
                <div style="padding: 1.25rem 1.5rem;">
                    <div style="font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 12px;">Career info</div>
                    @foreach([
                      ['Coach',      $athlete->coach_name],
                      ['Club',       $athlete->club_name],
                      ['Experience', $athlete->experience_years.' yrs'],
                      ['World rank', '#'.$athlete->world_rank],
                      ['Position',   $athlete->rank_position],
                    ] as [$label, $value])
                        <div style="display:flex; justify-content:space-between; font-size:14px; padding: 7px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color:#6b7280;">{{ $label }}</span>
                            <span style="color:#111827; font-weight:500;">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bio --}}
            <div style="padding: 1.25rem 1.5rem;">
                <div style="font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px;">Bio</div>

            <div class="bio-text">
                {!! $athlete->bio_uz !!}
            </div>
            </div>

        </div>
    </div>
@endsection
