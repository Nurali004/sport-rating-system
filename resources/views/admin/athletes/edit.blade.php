@extends('layouts.backend')
@section('title', 'Edit Athlete')
@section('admin')

    {{-- TinyMCE (bir marta) --}}
    <script src="https://cdn.tiny.cloud/1/rbkz9i8rqsas1gz13z0ng7u11p63iuep3dggf71qz0pgdpbd/tinymce/6/tinymce.min.js"></script>
    <script>
        tinymce.init({ selector: '.tinymce-editor', height: 220, menubar: false,
            plugins: 'lists link', toolbar: 'bold italic underline | bullist numlist | link' });
    </script>

    <style>
        .ae-card       { background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:1.25rem; }
        .ae-card-head  { padding:.9rem 1.25rem; background:#f9fafb; border-bottom:1px solid #e5e7eb;
            font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:.07em; }
        .ae-body       { padding:1.25rem; }
        .ae-label      { display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:5px; }
        .ae-input      { width:100%; padding:8px 11px; border:1px solid #d1d5db; border-radius:8px;
            font-size:14px; color:#111827; background:#fff; outline:none; transition:border .15s; }
        .ae-input:focus{ border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); }
        .ae-select     { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 11px center; padding-right:30px; }
        .ae-row        { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem; }
        .ae-row-3      { display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem; margin-bottom:1rem; }
        .ae-row-1      { margin-bottom:1rem; }
        .ae-field      { display:flex; flex-direction:column; }

        /* Image upload */
        .img-upload-wrap { position:relative; border:2px dashed #d1d5db; border-radius:10px;
            overflow:hidden; cursor:pointer; transition:border .15s; background:#fafafa; }
        .img-upload-wrap:hover { border-color:#6366f1; }
        .img-upload-wrap input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; z-index:2; }
        .img-preview    { width:100%; display:block; object-fit:cover; }
        .img-placeholder{ display:flex; flex-direction:column; align-items:center; justify-content:center;
            gap:8px; padding:2rem; color:#9ca3af; font-size:13px; }
        .img-placeholder svg { width:32px; height:32px; }
        .img-badge      { position:absolute; bottom:8px; right:8px; background:rgba(0,0,0,.55);
            color:#fff; font-size:11px; padding:3px 9px; border-radius:20px; z-index:3; pointer-events:none; }

        /* Toggle switch */
        .toggle-wrap    { display:flex; align-items:center; gap:10px; padding:9px 0; }
        .toggle-track   { position:relative; width:40px; height:22px; background:#d1d5db;
            border-radius:11px; cursor:pointer; transition:background .2s; flex-shrink:0; }
        .toggle-track input { position:absolute; opacity:0; width:100%; height:100%; cursor:pointer; margin:0; }
        .toggle-track input:checked + span { transform:translateX(18px); }
        .toggle-track:has(input:checked) { background:#6366f1; }
        .toggle-knob    { position:absolute; top:3px; left:3px; width:16px; height:16px;
            background:#fff; border-radius:50%; transition:transform .2s; pointer-events:none; }
        .toggle-lbl     { font-size:14px; color:#374151; }

        /* Save button */
        .ae-save-btn    { display:inline-flex; align-items:center; gap:7px; background:#6366f1;
            color:#fff; font-size:14px; font-weight:500; padding:9px 22px;
            border-radius:8px; border:none; cursor:pointer; transition:background .15s; }
        .ae-save-btn:hover { background:#4f46e5; }

        @media(max-width:640px){ .ae-row,.ae-row-3{ grid-template-columns:1fr; } }
    </style>

    <div style="padding:1.5rem; max-width:900px; margin:0 auto;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <div>
                <h2 style="font-size:20px; font-weight:600; color:#111827; margin:0;">Edit Athlete</h2>
                <p style="font-size:13px; color:#6b7280; margin:3px 0 0;">{{ $athlete->first_name }} {{ $athlete->last_name }}</p>
            </div>
            <a href="{{ route('admin.athletes.show', $athlete->id) }}"
               style="font-size:13px; color:#6366f1; text-decoration:none;">← Back to profile</a>
        </div>

        @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

        <form action="{{ route('admin.athletes.update', $athlete->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ── PHOTOS ─────────────────────────────────────────────────────── --}}
            <div class="ae-card">
                <div class="ae-card-head">Photos</div>
                <div class="ae-body">
                    <div class="ae-row">

                        {{-- Profile photo --}}
                        <div class="ae-field">
                            <span class="ae-label">Profile Photo</span>
                            <div class="img-upload-wrap" style="height:200px;"
                                 onclick="document.getElementById('photo-input').click()">
                                <input type="file" id="photo-input" name="photo" accept="image/*"
                                       onchange="previewImg(this,'photo-preview','photo-placeholder')">
                                @if($athlete->photo)
                                    <img id="photo-preview" class="img-preview" style="height:200px;"
                                         src="{{ asset('images/athletes/'.$athlete->photo) }}" alt="Photo">
                                    <div id="photo-placeholder" style="display:none;"></div>
                                @else
                                    <img id="photo-preview" class="img-preview" style="height:200px; display:none;" src="" alt="">
                                    <div id="photo-placeholder" class="img-placeholder">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                                        </svg>
                                        <span>Click to upload photo</span>
                                        <span style="font-size:11px; color:#d1d5db;">JPG, PNG · max 2MB</span>
                                    </div>
                                @endif
                                <span class="img-badge">Profile</span>
                            </div>
                        </div>

                        {{-- Cover photo --}}
                        <div class="ae-field">
                            <span class="ae-label">Cover Photo</span>
                            <div class="img-upload-wrap" style="height:200px;"
                                 onclick="document.getElementById('cover-input').click()">
                                <input type="file" id="cover-input" name="cover_photo[]" multiple accept="image/*"
                                       onchange="previewImg(this,'cover-preview','cover-placeholder')">
                                @if($athlete->cover_photo)
                                    @php $cover_photos = json_decode($athlete->cover_photo, true); @endphp
                                    @foreach($cover_photos as $photo)
                                        <img id="cover-preview" class="img-preview" style="height:200px; object-fit:cover;"
                                             src="{{ asset('images/athletes/'.$photo) }}" alt="Cover">
                                    @endforeach

                                    <div id="cover-placeholder" style="display:none;"></div>
                                @else
                                    <img id="cover-preview" class="img-preview" style="height:200px; display:none;" src="" alt="">
                                    <div id="cover-placeholder" class="img-placeholder">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v13.5A1.5 1.5 0 0 0 3.75 21Z"/>
                                        </svg>
                                        <span>Click to upload cover</span>
                                        <span style="font-size:11px; color:#d1d5db;">JPG, PNG · 16:9 recommended</span>
                                    </div>
                                @endif
                                <span class="img-badge">Cover</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── PERSONAL INFO ───────────────────────────────────────────────── --}}
            <div class="ae-card">
                <div class="ae-card-head">Personal Info</div>
                <div class="ae-body">
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">First Name</label>
                            <input class="ae-input" type="text" name="first_name" value="{{ $athlete->first_name }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Last Name</label>
                            <input class="ae-input" type="text" name="last_name" value="{{ $athlete->last_name }}">
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Middle Name</label>
                            <input class="ae-input" type="text" name="middle_name" value="{{ $athlete->middle_name }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Birth Date</label>
                            <input class="ae-input" type="date" name="birth_date" value="{{ $athlete->birth_date }}">
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Gender</label>
                            <select name="gender" class="ae-input ae-select">
                                <option value="male"   @if($athlete->gender=='male')   selected @endif>Male</option>
                                <option value="female" @if($athlete->gender=='female') selected @endif>Female</option>
                            </select>
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Region</label>
                            <select name="region_id" class="ae-input ae-select">
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" @if($athlete->region_id==$region->id) selected @endif>
                                        {{ $region->name_uz }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Height (cm)</label>
                            <input class="ae-input" type="text" name="height" value="{{ $athlete->height }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Weight (kg)</label>
                            <input class="ae-input" type="text" name="weight" value="{{ $athlete->weight }}">
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Weight Category</label>
                            <input class="ae-input" type="text" name="weight_category" value="{{ $athlete->weight_category }}">
                        </div>
                        <div class="ae-field" style="justify-content:flex-end; padding-bottom:2px;">
                            <label class="ae-label">National Team</label>
                            <label class="toggle-wrap">
              <span class="toggle-track">
                <input type="hidden" name="is_national_team" value="0">
                <input type="checkbox" name="is_national_team" value="1"
                       @if($athlete->is_national_team) checked @endif>
                <span class="toggle-knob"></span>
              </span>
                                <span class="toggle-lbl">Member of national team</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CAREER INFO ─────────────────────────────────────────────────── --}}
            <div class="ae-card">
                <div class="ae-card-head">Career Info</div>
                <div class="ae-body">
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Sport Category</label>
                            <select name="sport_id" class="ae-input ae-select">
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" @if($athlete->sport_id==$sport->id) selected @endif>
                                        {{ $sport->name_uz }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Coach Name</label>
                            <input class="ae-input" type="text" name="coach_name" value="{{ $athlete->coach_name }}">
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Club Name</label>
                            <input class="ae-input" type="text" name="club_name" value="{{ $athlete->club_name }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Experience (years)</label>
                            <input class="ae-input" type="number" name="experience_years" value="{{ $athlete->experience_years }}">
                        </div>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Status</label>
                            <select name="status" class="ae-input ae-select">
                                <option value="active"   @if($athlete->status=='active')   selected @endif>Active</option>
                                <option value="inactive" @if($athlete->status=='inactive') selected @endif>Inactive</option>
                                <option value="retired"  @if($athlete->status=='retired')  selected @endif>Retired</option>
                            </select>
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">World Rank</label>
                            <input class="ae-input" type="number" name="world_rank" value="{{ $athlete->world_rank }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STATS ───────────────────────────────────────────────────────── --}}
            <div class="ae-card">
                <div class="ae-card-head">Stats & Medals</div>
                <div class="ae-body">
                    <div class="ae-row-3">
                        <div class="ae-field">
                            <label class="ae-label">Rating Score</label>
                            <input class="ae-input" type="number" name="rating_score" value="{{ $athlete->rating_score }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Rating Position</label>
                            <input class="ae-input" type="number" name="rank_position" value="{{ $athlete->rank_position }}">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">World Rank</label>
                            <input class="ae-input" type="number" name="rank_position" value="{{ $athlete->rank_position }}">
                        </div>
                    </div>
                    <div class="ae-row-3">
                        <div class="ae-field">
                            <label class="ae-label" style="color:#b45309;">🥇 Gold Medals</label>
                            <input class="ae-input" type="number" name="gold_medals" value="{{ $athlete->gold_medals }}"
                                   style="border-color:#fcd34d;">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label" style="color:#6b7280;">🥈 Silver Medals</label>
                            <input class="ae-input" type="number" name="silver_medals" value="{{ $athlete->silver_medals }}"
                                   style="border-color:#d1d5db;">
                        </div>
                        <div class="ae-field">
                            <label class="ae-label" style="color:#92400e;">🥉 Bronze Medals</label>
                            <input class="ae-input" type="number" name="bronze_medals" value="{{ $athlete->bronze_medals }}"
                                   style="border-color:#d97706;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── BIO ──────────────────────────────────────────────────────────── --}}
            <div class="ae-card">
                <div class="ae-card-head">Biography</div>
                <div class="ae-body">
                    <div class="ae-row-1">
                        <label class="ae-label">Bio (UZ)</label>
                        <textarea name="bio_uz" class="tinymce-editor ae-input"
                                  style="height:180px;">{{ $athlete->bio_uz }}</textarea>
                    </div>
                    <div class="ae-row">
                        <div class="ae-field">
                            <label class="ae-label">Bio (EN)</label>
                            <textarea name="bio_en" class="tinymce-editor ae-input"
                                      style="height:180px;">{{ $athlete->bio_en }}</textarea>
                        </div>
                        <div class="ae-field">
                            <label class="ae-label">Bio (RU)</label>
                            <textarea name="bio_ru" class="tinymce-editor ae-input"
                                      style="height:180px;">{{ $athlete->bio_ru }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── ACTIONS ──────────────────────────────────────────────────────── --}}
            <div style="display:flex; justify-content:flex-end; gap:10px; padding-bottom:1rem;">
                <a href="{{ route('admin.athletes.show', $athlete->id) }}"
                   style="display:inline-flex; align-items:center; padding:9px 20px; border:1px solid #d1d5db;
                border-radius:8px; font-size:14px; color:#374151; text-decoration:none; background:#fff;">
                    Cancel
                </a>
                <button type="submit" class="ae-save-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 3v4H7V3M12 12v6m-3-3h6"/>
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>
    </div>

    <script>
        function previewImg(input, previewId, placeholderId) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    </script>
@endsection
