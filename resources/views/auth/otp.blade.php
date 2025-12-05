@extends('master.master')

@section('custom-css')
<link rel="stylesheet" href="/css/auth.css">
@endsection

@section('content')
<div class="otp-page">
  <div class="otp-card text-center">
    <div class="icon-circle">
      <iconify-icon icon="mdi:email-outline" width="36" height="36" style="color: #2563EB;"></iconify-icon>
    </div>

    <h4 class="mb-1">Enter OTP Code</h4>
    <p class="text-muted small mb-3">Didn't receive code? <a href="#" id="resendLink">Resend OTP</a></p>

    <form id="otpForm" action="{{ route('otp.verify') }}" method="POST" onsubmit="collectAndSubmit(event)">
      @csrf

      <div class="d-flex justify-content-center gap-2 mb-3">
        @for ($i = 1; $i <= 6; $i++)
          <input class="form-control otp-input" name="otp{{ $i }}" inputmode="numeric" pattern="\d*" maxlength="1" required>
        @endfor
      </div>

      <input type="hidden" name="otp" id="combinedOtp">

      <button type="submit" class="btn btn-primary w-100 mb-2">Confirm</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js" defer></script>

<script>
document.addEventListener('input', (e) => {
  const el = e.target;
  if (!el || el.tagName !== 'INPUT' || el.maxLength !== 1) return;
  if (el.value.length === 1) {
    const next = el.nextElementSibling;
    if (next && next.tagName === 'INPUT') next.focus();
  }
});

document.addEventListener('keydown', (e) => {
  const el = e.target;
  if (!el || el.tagName !== 'INPUT' || el.maxLength !== 1) return;
  if (e.key === 'Backspace' && el.value === '') {
    const prev = el.previousElementSibling;
    if (prev && prev.tagName === 'INPUT') {
      prev.focus();
      prev.value = '';
    }
  }
});

function collectAndSubmit(evt) {
  const inputs = Array.from(document.querySelectorAll('.otp-input'));
  const otp = inputs.map(i => i.value.trim()).join('');
  document.getElementById('combinedOtp').value = otp;
}

window.addEventListener('load', () => {
  const first = document.querySelector('.otp-input');
  if (first) first.focus();
});
</script>
@endsection
