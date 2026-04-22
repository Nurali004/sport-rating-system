@extends('layouts.front')
@section('title', 'Dashboard Page')
@section('front')
    @php
        $athletes = \App\Models\Athlete::limit(6)->get();
        $ratings = \App\Models\Rating::limit(4)->get();
        $competitions = \App\Models\Competition::limit(4)->get();
        $name = 'name'.'_'.app()->getLocale();
        $title = 'title'.'_'.app()->getLocale();
    @endphp
    <main class="page-wrapper">

        <!-- HERO -->
        <section class="hero-section">
            <div class="container">
                <div class="fade-up fade-up-1">
                    <h1 class="hero-title">@lang('messages.sport')<br><span>@lang('messages.reyting')</span></h1>
                    <p class="hero-subtitle">@lang('messages.title')</p>
                </div>
                <div class="hero-stats fade-up fade-up-2">
                    <div>
                        <span class="hero-stat-num">847</span>
                        <span class="hero-stat-label">@lang('messages.athletes')</span>
                    </div>
                    <div>
                        <span class="hero-stat-num">12</span>
                        <span class="hero-stat-label">@lang('messages.sports')</span>
                    </div>
                    <div>
                        <span class="hero-stat-num">234</span>
                        <span class="hero-stat-label">@lang('messages.competitions')</span>
                    </div>
                    <div>
                        <span class="hero-stat-num">1.2K</span>
                        <span class="hero-stat-label">@lang('messages.medals')</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- TOP 3 ATHLETES -->
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <div class="section-label">@lang('messages.nice_athletes')</div>
                        <div class="section-title">@lang('messages.top_athletes')</div>
                    </div>
                    <a href="{{route('frontend.athletes.list')}}" class="btn-outline">@lang('messages.view')</a>
                </div>
                <div class="row">

                    <!-- Athlete card — Nusxa: har bir sportchi uchun takrorlang -->
                    @foreach($athletes as $athlete)
                        <div class="col-md-4 fade-up fade-up-1">
                            <div class="athlete-card">
                                <div class="rank-badge gold">1</div>
                                <div class="athlete-card-img">
                                    <a href="{{route('frontend.athletes.show', $athlete->id)}}">
                                        <img src="{{asset('images/athletes/'. $athlete->photo)}}" width="350" alt="">
                                    </a>
                                </div>
                                <div class="athlete-card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <a href="{{route('frontend.athletes.show', $athlete->id)}}">
                                            <div>
                                                <div class="athlete-name">{{$athlete->first_name}}</div>
                                                <div class="athlete-sport">{{$athlete->sport->$name}}
                                                    · {{$athlete->region->$name}}</div>
                                            </div>
                                        </a>

                                        <div class="text-end">
                                            <div class="athlete-points">{{$athlete->rating_score}}</div>
                                            <div class="tbl-sub">pts</div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <span class="tag blue">🇺🇿 {{$athlete->club_name}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>

        <!-- RATING TABLE (preview) -->
        <section class="py-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <div class="section-label">@lang('messages.schedule')</div>
                        <div class="section-title">@lang('messages.now_reyting')</div>
                    </div>
                    <a href="{{route('frontend.ratings.list')}}" class="btn-outline">@lang('messages.view')</a>
                </div>
                <div class="card-dark p-3">
                    <div class="table-responsive">
                        <table class="rating-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('messages.athlete')</th>
                                <th>@lang('messages.sport_type')</th>
                                <th>@lang('messages.region')</th>
                                <th>@lang('messages.point')</th>
                                <th>@lang('messages.rank')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Row nusxasi — takrorlang -->
                            @foreach($ratings as $rating)
                                <tr onclick="location.href='{{route('frontend.athletes.list')}}'">
                                    <td>
                                        <div class="rank-num top1">🥇</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="athlete-mini-img">🥊</div>
                                            <div>
                                                <div
                                                    class="tbl-name">{{$rating->athlete->first_name. ' '. $rating->athlete->last_name}}</div>
                                                <div class="tbl-sub">29 yosh</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="tag">{{$rating->sport->$name}}</span></td>
                                    <td class="tbl-sub">{{$rating->athlete->region->$name}}</td>
                                    <td>
                                        <div
                                            style="font-family:'Bebas Neue';font-size:1.2rem;color:var(--accent2)">{{$rating->total_points}}
                                        </div>
                                        <div class="score-bar-wrap">
                                            <div class="score-bar">
                                                <div class="score-bar-fill" data-width="95" style="width:0"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="trend-up">{{$rating->rank_position}}</span></td>
                                </tr>
                            @endforeach


                            <!-- ... qo'shimcha rowlar shu yerga -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- COMPETITIONS + NEWS -->
        <section class="py-5">
            <div class="container">
                <div class="row">

                    <!-- Musobaqalar -->
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <div>
                                <div class="section-label">@lang('messages.near_events')</div>
                                <div class="section-title" style="font-size:1.6rem">@lang('messages.competitions')</div>
                            </div>
                            <a href="{{route('frontend.competitions.list')}}" class="btn-outline"
                               style="font-size:0.78rem;padding:0.3rem 0.8rem">@lang('messages.view')</a>
                        </div>
                        <div class="row">
                            @foreach($competitions as $competition)
                                <div class="col-md-6">
                                    <div class="comp-card international fade-up">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <a href="{{route('frontend.competitions.show', $competition->id)}}">
                                                <div>
                                                    <span class="comp-level international">{{$competition->level}}</span>
                                                    <div class="comp-title">{{$competition->$title}}</div>
                                                    <div class="comp-meta">🏅 {{$competition->sport->$name}} &nbsp;·&nbsp; 📅 {{$competition->start_date}}</div>
                                                    <div class="comp-meta mt-1">📍 {{$competition->location.'_'.app()->getLocale()}} &nbsp;·&nbsp; 👤 {{$competition->participants_count}} ishtirokchi
                                                    </div>
                                                </div>
                                            </a>

                                            <div style="font-size:2rem"><img src="{{asset('images/competitions/'. $competition->image)}}" width="150" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <div>
                                <div class="section-label">@lang('messages.sport_news')</div>
                                <div class="section-title" style="font-size:1.6rem">@lang('messages.news')</div>
                            </div>
                            <a href="news.html" class="btn-outline" style="font-size:0.78rem;padding:0.3rem 0.8rem">@lang('messages.view')</a>
                        </div>
                        <div class="row">

                            <!-- News card nusxasi -->
                            <div class="col-md-4 fade-up">
                                <div class="news-card">
                                    <div class="news-card-img">🏆</div>
                                    <div class="news-card-body">
                                        <div class="news-category">Natijalar</div>
                                        <div class="news-title">Yangilik sarlavhasi shu yerga yoziladi</div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="news-date">📅 2025-01-15</span>
                                            <span class="news-date">👁 12,500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 fade-up">
                                <div class="news-card">
                                    <div class="news-card-img">🎤</div>
                                    <div class="news-card-body">
                                        <div class="news-category">Suhbat</div>
                                        <div class="news-title">Yangilik sarlavhasi shu yerga yoziladi</div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="news-date">📅 2025-01-12</span>
                                            <span class="news-date">👁 8,900</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 fade-up">
                                <div class="news-card">
                                    <div class="news-card-img">📢</div>
                                    <div class="news-card-body">
                                        <div class="news-category">Tadbir</div>
                                        <div class="news-title">Yangilik sarlavhasi shu yerga yoziladi</div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="news-date">📅 2025-01-10</span>
                                            <span class="news-date">👁 6,700</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Yangiliklar -->
            </div>
            </div>
        </section>

    </main>
@endsection
