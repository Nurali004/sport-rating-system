
@extends('layouts.backend')
@section('title', 'Create Competition')
@section('admin')

    <style>
        .form-card {
            background: #fff;
            border: 0.5px solid #e5e4e0;
            border-radius: 12px;
            padding: 2rem;
            margin: 1.5rem 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .form-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .header-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: #EEEDFE;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .form-header h2 { font-size: 18px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .form-header p  { font-size: 13px; color: #888; margin: 2px 0 0; }

        .section-title {
            font-size: 11px; font-weight: 600;
            color: #aaa; text-transform: uppercase;
            letter-spacing: 0.07em;
            margin: 1.75rem 0 1rem;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }

        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 13px; font-weight: 500; color: #555; }

        .field .form-control {
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            transition: border-color 0.15s;
            outline: none;
            width: 100%;
        }
        .field .form-control:focus {
            border-color: #7F77DD;
            box-shadow: 0 0 0 3px rgba(127,119,221,0.12);
        }
        .field textarea.form-control { resize: vertical; min-height: 100px; }

        /* Level toggle buttons */
        .level-group { display: flex; gap: 8px; flex-wrap: wrap; }
        .level-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            transition: all 0.15s;
        }
        .level-btn:hover { background: #f5f4f0; }
        .level-btn.active.int    { background: #FAEEDA; border-color: #FAC775; color: #633806; }
        .level-btn.active.nat    { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }
        .level-btn.active.reg    { background: #E1F5EE; border-color: #5DCAA5; color: #0F6E56; }
        .level-btn.active.loc    { background: #F1EFE8; border-color: #B4B2A9; color: #5F5E5A; }

        /* Status toggle */
        .status-group { display: flex; gap: 8px; flex-wrap: wrap; }
        .status-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            transition: all 0.15s;
        }
        .status-btn:hover { background: #f5f4f0; }
        .status-btn.active.upcoming  { background: #E6F1FB; border-color: #85B7EB; color: #185FA5; }
        .status-btn.active.ongoing   { background: #EAF3DE; border-color: #97C459; color: #3B6D11; }
        .status-btn.active.completed { background: #F1EFE8; border-color: #B4B2A9; color: #5F5E5A; }
        .status-btn.active.cancelled { background: #FCEBEB; border-color: #F09595; color: #A32D2D; }

        /* Rating buttons */
        .rating-group { display: flex; gap: 8px; flex-wrap: wrap; }
        .rating-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            transition: all 0.15s;
        }
        .rating-btn:hover { background: #f5f4f0; }
        .rating-btn.active { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }

        /* Image upload */
        .upload-box {
            border: 1px dashed #d0cfc8;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
            position: relative;
        }
        .upload-box:hover { border-color: #7F77DD; background: #EEEDFE22; }
        .upload-box input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .upload-icon { font-size: 2rem; margin-bottom: 0.5rem; }
        .upload-text { font-size: 13px; color: #888; }
        .upload-text span { color: #534AB7; font-weight: 500; }
        #preview-img { width: 100%; border-radius: 8px; margin-top: 0.75rem; display: none; max-height: 160px; object-fit: cover; }

        /* Tabs for descriptions */
        .tab-nav { display: flex; gap: 0; border-bottom: 0.5px solid #e5e4e0; margin-bottom: 1rem; }
        .tab-btn {
            padding: 8px 16px;
            border: none; background: transparent;
            font-size: 13px; font-weight: 500; color: #888;
            cursor: pointer; border-bottom: 2px solid transparent;
            margin-bottom: -0.5px; transition: all 0.15s;
        }
        .tab-btn:hover { color: #1a1a1a; }
        .tab-btn.active { color: #534AB7; border-bottom-color: #534AB7; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* Submit */
        .submit-row {
            display: flex; justify-content: flex-end;
            align-items: center; gap: 10px;
            margin-top: 2rem; padding-top: 1.5rem;
            border-top: 0.5px solid #e5e4e0;
        }
        .btn-cancel {
            padding: 9px 22px; border-radius: 8px;
            border: 0.5px solid #d0cfc8; background: transparent;
            cursor: pointer; font-size: 14px; font-weight: 500;
            color: #666; text-decoration: none;
        }
        .btn-cancel:hover { background: #f5f4f0; color: #444; }
        .btn-submit {
            padding: 9px 26px; border-radius: 8px;
            border: none; background: #534AB7;
            cursor: pointer; font-size: 14px; font-weight: 500;
            color: #fff; transition: background 0.15s;
        }
        .btn-submit:hover { background: #3C3489; }

        @media(max-width: 640px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .form-card { padding: 1.25rem; }
        }
    </style>

    @if($errors->any())
        <div class="alert alert-danger" style="margin-top:1rem">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container" style="max-width: 860px;">

        @if($errors->any())
            <div style="background:#FCEBEB;border:0.5px solid #F09595;border-radius:8px;padding:12px 16px;margin:1rem 0">
                @foreach($errors->all() as $error)
                    <div style="font-size:13px;color:#A32D2D">• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-card">

            {{-- Header --}}
            <div class="form-header">
                <div class="header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.8">
                        <circle cx="12" cy="8" r="6"/>
                        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                </div>
                <div>
                    <h2>Yangi musobaqa</h2>
                    <p>Musobaqa ma'lumotlarini to'ldiring</p>
                </div>
            </div>

            <form action="{{ route('admin.competitions.update', $competition->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                {{-- Hidden inputs --}}
                <input type="hidden" name="level"  id="level_input"  value="{{ $competition->level }}">
                <input type="hidden" name="status" id="status_input" value="{{ $competition->status }}">
                <input type="hidden" name="rating" id="rating_input" value="{{ $competition->rating }}">

                {{-- 1. Nomlar --}}
                <p class="section-title">Nomlar</p>
                <div class="grid-3">
                    <div class="field">
                        <label>Nomi (UZ)</label>
                        <input type="text"  name="title_uz" class="form-control" placeholder="O'zbekcha nom" value="{{ $competition->title_uz }}" required>
                    </div>
                    <div class="field">
                        <label>Nomi (EN)</label>
                        <input type="text" name="title_en" class="form-control" placeholder="English name" value="{{ $competition->title_en }}" required>
                    </div>
                    <div class="field">
                        <label>Nomi (RU)</label>
                        <input type="text" name="title_ru" class="form-control" placeholder="Русское название" value="{{ $competition->title_ru }}" required>
                    </div>
                </div>

                {{-- 2. Asosiy --}}
                <p class="section-title">Asosiy ma'lumot</p>
                <div class="grid-2" style="margin-bottom:1.25rem">
                    <div class="field">
                        <label>Sport turi</label>
                        <select name="sport_id" class="form-control" required>
                            <option value="">Sport turini tanlang</option>
                            @foreach ($sports as $sport)
                                <option value="{{ $sport->id }}" {{ $competition->sport_id == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name_uz }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Mavsum</label>
                        <select name="season_id" class="form-control" required>
                            <option value="">Mavsum tanlang</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}" {{ $competition->season_id == $season->id ? 'selected' : '' }}>
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field" style="margin-bottom:1.25rem">
                    <label>Tashkilotchi</label>
                    <input type="text" name="organizer" class="form-control" placeholder="Tashkilot nomi" value="{{ $competition->organizer }}" required>
                </div>

                {{-- 3. Daraja --}}
                <p class="section-title">Daraja</p>
                <div class="field" style="margin-bottom:1.25rem">
                    <div class="level-group">
                        <button type="button" class="level-btn int {{$competition->level == 'international' ? 'active' : ''}}" data-value="international" onclick="selectLevel(this)">🌍 Xalqaro</button>
                        <button type="button" class="level-btn nat {{$competition->level == 'national' ? 'active' : ''}}" data-value="national"      onclick="selectLevel(this)">🇺🇿 Respublika</button>
                        <button type="button" class="level-btn reg {{$competition->level == 'regional' ? 'active' : ''}}" data-value="regional"      onclick="selectLevel(this)">📍 Viloyat</button>
                        <button type="button" class="level-btn loc {{$competition->level == 'local' ? 'active' : ''}}" data-value="local"         onclick="selectLevel(this)">🏘️ Mahalliy</button>
                    </div>
                </div>

                {{-- 4. Reyting koeffitsient --}}
                <p class="section-title">Reyting koeffitsienti</p>
                <div class="field" style="margin-bottom:1.25rem">
                    <div class="rating-group">
                        <button type="button" class="rating-btn {{$competition->rating == 0.5 ? 'active' : ''}}" data-value="0.5" onclick="selectRating(this)">0.5 — Mahalliy</button>
                        <button type="button" class="rating-btn {{$competition->rating == 1.0 ? 'active' : ''}}" data-value="1.0" onclick="selectRating(this)">1.0 — Viloyat</button>
                        <button type="button" class="rating-btn {{$competition->rating == 2.0 ? 'active' : ''}}" data-value="2.0" onclick="selectRating(this)">2.0 — Respublika</button>
                        <button type="button" class="rating-btn {{$competition->rating == 3.0 ? 'active' : ''}}" data-value="3.0" onclick="selectRating(this)">3.0 — Xalqaro</button>
                    </div>
                </div>

                {{-- 5. Manzil --}}
                <p class="section-title">Manzil</p>
                <div class="grid-3" style="margin-bottom:1.25rem">
                    <div class="field">
                        <label>Manzil (UZ)</label>
                        <input type="text" name="location_uz" class="form-control" placeholder="Toshkent, O'zbekiston" value="{{ $competition->location_uz }}" required>
                    </div>
                    <div class="field">
                        <label>Manzil (EN)</label>
                        <input type="text" name="location_en" class="form-control" placeholder="Tashkent, Uzbekistan" value="{{ $competition->location_en }}" required>
                    </div>
                    <div class="field">
                        <label>Manzil (RU)</label>
                        <input type="text" name="location_ru" class="form-control" placeholder="Ташкент, Узбекистан" value="{{ $competition->location_ru }}" required>
                    </div>
                </div>
                <div class="field" style="margin-bottom:1.25rem">
                    <label>Mamlakat</label>
                    <input type="text" name="location_country" class="form-control" placeholder="O'zbekiston" value="{{ $competition->location_country }}">
                </div>

                {{-- 6. Sana va holat --}}
                <p class="section-title">Sana va holat</p>
                <div class="grid-2" style="margin-bottom:1.25rem">
                    <div class="field">
                        <label>Boshlanish sanasi</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $competition->start_date }}" required>
                    </div>
                    <div class="field">
                        <label>Tugash sanasi</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $competition->end_date }}" required>
                    </div>
                </div>

                <div class="grid-2" style="margin-bottom:1.25rem">
                    <div class="field">
                        <label>Ishtirokchilar soni</label>
                        <input type="number" name="participants_count" class="form-control" placeholder="0" value="{{ $competition->participants_count }}" required>
                    </div>
                    <div class="field">
                        <label>Holat</label>
                        <div class="status-group" style="margin-top:2px">
                            <button type="button" class="status-btn upcoming {{$competition->status == 'upcoming' ? 'active' : ''}}"  data-value="upcoming"  onclick="selectStatus(this)">Kutilmoqda</button>
                            <button type="button" class="status-btn ongoing {{$competition->status == 'ongoing' ? 'active' : ''}}"   data-value="ongoing"   onclick="selectStatus(this)">Davom etmoqda</button>
                            <button type="button" class="status-btn completed {{$competition->status == 'completed' ? 'active' : ''}}" data-value="completed" onclick="selectStatus(this)">Yakunlangan</button>
                            <button type="button" class="status-btn cancelled {{$competition->status == 'cancelled' ? 'active' : ''}}" data-value="cancelled" onclick="selectStatus(this)">Bekor</button>
                        </div>
                    </div>
                </div>

                {{-- 7. Rasm --}}
                <p class="section-title">Rasm</p>
                <div class="upload-box" style="margin-bottom:1.25rem" onclick="document.getElementById('img-input').click()">
                    <input type="file" id="img-input" name="image" accept="image/*" onchange="previewImage(this)" style="display:none">
                    <div class="upload-icon">🖼️</div>
                    <div class="upload-text">Rasm yuklash uchun <span>bosing</span> yoki sudrab tashlang</div>
                    <div style="font-size:11px;color:#aaa;margin-top:4px">PNG, JPG, WEBP — max 2MB</div>
                    <img id="preview-img" src="" alt="">
                </div>

                {{-- 8. Tavsif --}}
                <p class="section-title">Tavsif</p>
                <div class="tab-nav">
                    <button type="button" class="tab-btn active" onclick="switchTab('uz', this)">🇺🇿 O'zbek</button>
                    <button type="button" class="tab-btn"        onclick="switchTab('en', this)">🇬🇧 English</button>
                    <button type="button" class="tab-btn"        onclick="switchTab('ru', this)">🇷🇺 Русский</button>
                </div>
                <div id="tab-uz" class="tab-pane active">
                    <textarea name="description_uz" class="form-control tinymce-editor" rows="5">
                        {{$competition->description_uz}}
                    </textarea>
                </div>
                <div id="tab-en" class="tab-pane">
                    <textarea name="description_en" class="form-control tinymce-editor" rows="5">
                        {{$competition->description_en}}
                    </textarea>
                </div>
                <div id="tab-ru" class="tab-pane">
                    <textarea name="description_ru" class="form-control tinymce-editor" rows="5">
                        {{$competition->description_ru}}
                    </textarea>
                </div>

                {{-- Submit --}}
                <div class="submit-row">
                    <a href="{{ route('admin.competitions.index') }}" class="btn-cancel">Bekor qilish</a>
                    <button type="submit" class="btn-submit">Saqlash</button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/rbkz9i8rqsas1gz13z0ng7u11p63iuep3dggf71qz0pgdpbd/tinymce/6/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-editor', height: 180, menubar: false,
            plugins: 'lists link',
            toolbar: 'bold italic underline | bullist numlist | link',
            content_style: 'body { font-family: system-ui, sans-serif; font-size: 14px; }'
        });

        function selectLevel(btn) {
            document.querySelectorAll('.level-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('level_input').value = btn.dataset.value;
        }

        function selectStatus(btn) {
            document.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('status_input').value = btn.dataset.value;
        }

        function selectRating(btn) {
            document.querySelectorAll('.rating-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('rating_input').value = btn.dataset.value;
        }

        function previewImage(input) {
            const img = document.getElementById('preview-img');
            if (input.files && input.files[0]) {
                img.src = URL.createObjectURL(input.files[0]);
                img.style.display = 'block';
            }
        }

        function switchTab(lang, btn) {
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + lang).classList.add('active');
            btn.classList.add('active');
        }
    </script>

@endsection
