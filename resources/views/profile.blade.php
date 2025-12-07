@extends('master.master')

@section('content')

<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-wrapper">
  <div class="card">
    <div class="row-flex">

      <aside class="menu">
        <h2>Settings</h2>
        <a href="{{ route('profile') }}" class="menu-link active">
          <iconify-icon icon="mdi:account-box-outline" width="20"></iconify-icon>
          <span>Profile</span>
        </a>
        <a href="#" class="menu-link">
          <iconify-icon icon="mdi:lock-outline" width="20"></iconify-icon>
          <span>Privacy</span>
        </a>
      </aside>

      <main class="content">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
          @csrf

          <div style="margin-bottom:24px">
            <div class="label">Profile Picture</div>
            <div style="display:flex;align-items:center;gap:28px;margin-top:8px">
              <img id="avatarPreview"
                src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/default-pfp.jpg') }}"
                class="avatar">

              <div style="display:flex;gap:12px;align-items:center">
                <button type="button" id="changeBtn" class="btn btn-change">Change Picture</button>
                <button type="button" id="deleteBtn" class="btn btn-delete">Delete Picture</button>
              </div>
            </div>

            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none">
            <input type="hidden" name="delete_avatar" id="deleteAvatar" value="0">
          </div>

          <div style="margin-top:26px">
            <div class="label">Name</div>
            <div class="input-wrapper" style="margin-top:6px">
              <input id="nameInput" name="name" type="text"
                     value="{{ old('name', $user->name) }}" class="input-pill" readonly>
              <iconify-icon id="editName" class="pencil" icon="mdi:pencil" width="18"></iconify-icon>
            </div>
          </div>

          <div style="margin-top:22px">
            <div class="label">E-mail</div>
            <div class="input-wrapper" style="margin-top:6px">
              <input id="emailInput" name="email" type="email"
                     value="{{ old('email', $user->email) }}" class="input-pill" readonly>
              <iconify-icon id="editEmail" class="pencil" icon="mdi:pencil" width="18"></iconify-icon>
            </div>
          </div>

          <div style="margin-top:22px">
            <button type="submit" id="saveBtn" class="save-btn" disabled>Save Changes</button>
          </div>

        </form>
      </main>

    </div>
  </div>
</div>

<script>
(function(){
  const avatarInput = document.getElementById('avatarInput')
  const avatarPreview = document.getElementById('avatarPreview')
  const changeBtn = document.getElementById('changeBtn')
  const deleteBtn = document.getElementById('deleteBtn')

  const editName = document.getElementById('editName')
  const editEmail = document.getElementById('editEmail')

  const nameInput = document.getElementById('nameInput')
  const emailInput = document.getElementById('emailInput')

  const saveBtn = document.getElementById('saveBtn')
  const deleteAvatarInput = document.getElementById('deleteAvatar')

  function enableSave(){
    saveBtn.disabled = false
    saveBtn.classList.add('enabled')
  }

  editName.addEventListener('click', () => {
    nameInput.readOnly = false
    nameInput.focus()
    const len = nameInput.value.length
    nameInput.setSelectionRange(len, len)
    enableSave()
})

editEmail.addEventListener('click', () => {
    emailInput.readOnly = false
    emailInput.focus()
    const len = emailInput.value.length
    emailInput.setSelectionRange(len, len)
    enableSave()
})

  changeBtn.addEventListener('click', ()=> avatarInput.click())

  avatarInput.addEventListener('change', e=>{
    const file = e.target.files[0]
    if(!file) return
    const reader = new FileReader()
    reader.onload = ev => avatarPreview.src = ev.target.result
    reader.readAsDataURL(file)
    deleteAvatarInput.value = 0
    enableSave()
  })

  deleteBtn.addEventListener('click', ()=>{
    deleteAvatarInput.value = 1
    avatarPreview.src = "{{ asset('assets/default-pfp.jpg') }}"
    avatarInput.value = ""
    enableSave()
  })

  nameInput.addEventListener('input', enableSave)
  emailInput.addEventListener('input', enableSave)
})();
</script>

@endsection
