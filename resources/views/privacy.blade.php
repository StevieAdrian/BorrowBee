@extends('master.master')

@section('content')

<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-wrapper">
  <div class="card">
    <div class="row-flex">

      <aside class="menu">
        <h2>Settings</h2>

        <a href="{{ route('profile') }}" class="menu-link {{ request()->routeIs('profile') ? 'active' : '' }}">
          <iconify-icon icon="mdi:account-box-outline" width="20"></iconify-icon>
          <span>Profile</span>
        </a>

        <a href="{{ route('privacy') }}" class="menu-link {{ request()->routeIs('privacy') ? 'active' : '' }}">
          <iconify-icon icon="mdi:lock-outline" width="20"></iconify-icon>
          <span>Privacy</span>
        </a>
      </aside>


      <main class="content">
        <h1>Change Password</h1>

        @if(session('success'))
          <div class="alert-success">
            {{ session('success') }}
          </div>
        @endif

        <form method="POST" action="{{ route('privacy.update') }}">
          @csrf

          <div class="form-group">
            <label for="current_password">Old Password</label>
            <div class="input-wrapper">
              <input
                type="password"
                id="current_password"
                name="current_password"
                placeholder="Enter your current password"
              >
              <span class="toggle-eye" data-target="current_password">
                <iconify-icon icon="mdi:eye-off-outline"></iconify-icon>
              </span>
            </div>
            @error('current_password')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>


          <div class="form-group">
            <label for="password">New Password</label>
            <div class="input-wrapper">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter new password"
              >
              <span class="toggle-eye" data-target="password">
                <iconify-icon icon="mdi:eye-off-outline"></iconify-icon>
              </span>
            </div>

            @error('password')
              <div class="password-requirements">
                <p>Please add all necessary characters to create safe password</p>

                <ul>
                  <li>Minimum characters 12</li>
                  <li>One Upper Case Character</li>
                  <li>One Lower Case Character</li>
                  <li>One Special Character</li>
                  <li>One Number</li>
                </ul>
              </div>
            @enderror
          </div>


          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-wrapper">
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Confirm your new password"
              >
              <span class="toggle-eye" data-target="password_confirmation">
                <iconify-icon icon="mdi:eye-off-outline"></iconify-icon>
              </span>
            </div>
          </div>


          {{-- button disabled initially --}}
          <button type="submit" class="save-btn disabled" disabled>Save Changes</button>

        </form>

      </main>

    </div>
  </div>
</div>


<script>
document.querySelectorAll('.toggle-eye').forEach(span => {
  span.addEventListener('click', () => {
    const targetId = span.dataset.target;
    const input = document.getElementById(targetId);
    if (!input) return;

    const iconEl = span.querySelector('iconify-icon');
    if (!iconEl) return;

    if (input.type === 'password') {
      input.type = 'text';
      iconEl.setAttribute('icon', 'mdi:eye-outline');
    } else {
      input.type = 'password';
      iconEl.setAttribute('icon', 'mdi:eye-off-outline');
    }
  });
});

function validateFields() {
  const oldPass = document.getElementById('current_password').value.trim();
  const newPass = document.getElementById('password').value.trim();
  const confirmPass = document.getElementById('password_confirmation').value.trim();

  const saveBtn = document.querySelector('.save-btn');

  if (oldPass && newPass && confirmPass) {
    saveBtn.disabled = false;
    saveBtn.classList.remove('disabled');
  } else {
    saveBtn.disabled = true;
    saveBtn.classList.add('disabled');
  }
}

document.getElementById('current_password').addEventListener('input', validateFields);
document.getElementById('password').addEventListener('input', validateFields);
document.getElementById('password_confirmation').addEventListener('input', validateFields);
</script>

@endsection
