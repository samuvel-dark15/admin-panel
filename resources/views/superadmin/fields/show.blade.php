<!DOCTYPE html>
<html>
<head>
  <title>Admin Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    body { margin:0; font-family:'Segoe UI',sans-serif; background:#f4f7fb; }

    header {
      background: linear-gradient(90deg,#6a11cb,#2575fc);
      color:white;
      padding:20px;
      text-align:center;
      font-size:22px;
    }

    .card {
      background:white;
      max-width:540px;
      margin:40px auto;
      padding:30px;
      border-radius:18px;
      box-shadow:0 10px 25px rgba(0,0,0,.12);
      text-align:center;
    }

    .profile-wrap { position:relative; display:inline-block; cursor:pointer; }

    .profile-img {
      width:140px; height:140px; border-radius:50%;
      object-fit:cover; box-shadow:0 8px 18px rgba(0,0,0,.18);
      transition:.25s ease;
    }

    .profile-wrap:hover .profile-img { transform: scale(1.06); }

    .zoom-hint {
      position:absolute; bottom:8px; right:8px;
      background:rgba(0,0,0,.6); color:white;
      padding:4px 7px; border-radius:10px; font-size:12px;
    }

    .placeholder {
      width:140px; height:140px; border-radius:50%;
      background:#ddd; display:flex; align-items:center;
      justify-content:center; font-size:46px; margin:auto; color:#666;
    }

    h2 { margin:18px 0 6px; font-size:26px; }

    .info { margin-top:16px; text-align:left; }

    .row {
      display:flex; justify-content:space-between;
      padding:10px 0; border-bottom:1px solid #eee;
      font-size:15px; gap:10px; flex-wrap:wrap;
    }

    .row span:first-child {
      font-weight:600; color:#333; min-width:130px;
    }

    .row span:last-child {
      color:#555; word-break:break-word;
      text-align:right; flex:1;
    }

    .actions {
      display:flex; justify-content:space-between;
      margin-top:28px; gap:12px; flex-wrap:wrap;
    }

    .btn {
      padding:12px 26px; border-radius:26px;
      text-decoration:none; font-size:15px;
      box-shadow:0 6px 15px rgba(0,0,0,.15);
      transition:.25s ease; border:none; cursor:pointer;
      display:inline-block; text-align:center;
    }

    .btn-back { background:linear-gradient(90deg,#2575fc,#6a11cb); color:white; }
    .btn-edit { background:linear-gradient(90deg,#ffc107,#ff9800); color:#333; }
    .btn-delete { background:linear-gradient(90deg,#ff4b5c,#c81d25); color:white; }

    .btn:hover { transform: translateY(-2px); }

    @media(max-width:600px){
      .card{ margin:20px; padding:22px; }
      .profile-img,.placeholder{ width:120px; height:120px; }
      h2{ font-size:22px; }
      .actions{ flex-direction:column; }
      .btn{ width:100%; }
      .row{ flex-direction:column; align-items:flex-start; }
      .row span:last-child{ text-align:left; }
    }

    .photo-modal {
      display:none; position:fixed; z-index:9999;
      top:0; left:0; width:100%; height:100%;
      background:rgba(0,0,0,.85);
      align-items:center; justify-content:center;
    }

    .photo-modal img {
      max-width:90%; max-height:90%;
      border-radius:16px; box-shadow:0 15px 40px rgba(0,0,0,.4);
    }

    .close-photo {
      position:absolute; top:20px; right:30px;
      color:white; font-size:32px; cursor:pointer;
    }
  </style>
</head>

<body>

<header>👤 Admin Details</header>

<div class="card">

  {{-- PHOTO --}}
  @if(!empty($admin->photo))
    <div class="profile-wrap" onclick="openPhoto('{{ asset($admin->photo) }}')">
      <img src="{{ asset($admin->photo) }}" class="profile-img">
      <div class="zoom-hint">🔍</div>
    </div>
  @else
    <div class="placeholder">👤</div>
  @endif

  {{-- DISPLAY NAME --}}
  <h2>
    {{ trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? '')) ?: $admin->name }}
  </h2>

  <div class="info">

    @php
      // Core display order
      $orderedKeys = [
        'name',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'email',
        'phone',
        'photo',
        'role',
        'status',
      ];

      $attributes = $admin->getAttributes();
      $hidden = ['id','password','remember_token','created_at','updated_at'];

      // Remove hidden fields
      foreach ($hidden as $h) unset($attributes[$h]);

      // Extract dynamic fields
      $dynamicFields = array_diff_key($attributes, array_flip($orderedKeys));
    @endphp

    {{-- CORE FIELDS --}}
    @foreach($orderedKeys as $key)

      @if(array_key_exists($key, $attributes))

        <div class="row">
          <span>{{ ucwords(str_replace('_',' ', $key)) }}</span>
          <span>
            @php $v = $attributes[$key]; @endphp

            @if(Str::contains($key, ['photo','image','file']) && !empty($v))
              <img src="{{ asset($v) }}" width="120" style="border-radius:10px;">
            @else
              {{ $v ?: '—' }}
            @endif
          </span>
        </div>

      @endif

    @endforeach


    {{-- DYNAMIC EXTRA FIELDS --}}
    @foreach($dynamicFields as $key => $value)

      <div class="row">
        <span>{{ ucwords(str_replace('_',' ', $key)) }}</span>
        <span>
          @if(Str::contains($key, ['photo','image','file']) && !empty($value))
            <img src="{{ asset($value) }}" width="120" style="border-radius:10px;">
          @else
            {{ $value ?: '—' }}
          @endif
        </span>
      </div>

    @endforeach


    {{-- CREATED --}}
    <div class="row">
      <span>Created</span>
      <span>{{ $admin->created_at ? $admin->created_at->format('d M Y') : '—' }}</span>
    </div>

  </div>

  {{-- STATUS TOGGLE --}}
  <form method="POST" action="{{ route('admins.status', $admin->id) }}" style="margin-top:18px;">
    @csrf
    @method('PUT')

    <button type="submit" class="btn"
      style="
        background: {{ $admin->status === 'active'
          ? 'linear-gradient(90deg,#ff4b5c,#c81d25)'
          : 'linear-gradient(90deg,#28a745,#20c997)' }};
        color:white; width:100%;
      ">
      {{ $admin->status === 'active' ? 'Deactivate Admin' : 'Activate Admin' }}
    </button>
  </form>

  {{-- ACTION BUTTONS --}}
  <form method="POST" action="{{ route('admins.destroy',$admin->id) }}">
    @csrf
    @method('DELETE')

    <div class="actions">

      <a href="{{ route('admins.index') }}" class="btn btn-back">⬅ Back</a>

      <a href="{{ route('admins.edit',$admin->id) }}" class="btn btn-edit">✏ Edit</a>

      <button type="submit" class="btn btn-delete"
        onclick="return confirm('Are you sure you want to delete this admin?')">
        🗑 Delete
      </button>

    </div>
  </form>

</div>

<!-- PHOTO MODAL -->
<div id="photoModal" class="photo-modal" onclick="closePhoto()">
  <span class="close-photo">×</span>
  <img id="photoModalImg">
</div>

<script>
function openPhoto(src){
  const modal = document.getElementById('photoModal');
  const img = document.getElementById('photoModalImg');
  img.src = src;
  modal.style.display = 'flex';
}

function closePhoto(){
  const modal = document.getElementById('photoModal');
  const img = document.getElementById('photoModalImg');
  modal.style.display = 'none';
  img.src = '';
}
</script>

</body>
</html>
