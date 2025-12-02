@extends('master.master')

@section('content')
<div class="otp-page d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-sm otp-card p-4">
    <div class="text-center mb-3">
      <div class="icon-circle mx-auto mb-2">
        <iconify-icon icon="mdi:email-outline" width="36" height="36" style="color: #2563EB;"></iconify-icon>
      </div>
      <h4 class="mb-1">Enter OTP Code</h4>
      <p class="text-muted small mb-3">Didn't receive code? <a href="#" id="resendLink">Resend OTP</a></p>
    </div>

    <form id="otpForm" action="{{ route('otp.verify') }}" method="POST" onsubmit="collectAndSubmit(event)">
      @csrf
      <div class="d-flex justify-content-center gap-2 mb-3">
        <input class="form-control otp-input" name="otp1" inputmode="numeric" pattern="\d*" maxlength="1" required>
        <input class="form-control otp-input" name="otp2" inputmode="numeric" pattern="\d*" maxlength="1" required>
        <input class="form-control otp-input" name="otp3" inputmode="numeric" pattern="\d*" maxlength="1" required>
        <input class="form-control otp-input" name="otp4" inputmode="numeric" pattern="\d*" maxlength="1" required>
        <input class="form-control otp-input" name="otp5" inputmode="numeric" pattern="\d*" maxlength="1" required>
        <input class="form-control otp-input" name="otp6" inputmode="numeric" pattern="\d*" maxlength="1" required>
      </div>

      <input type="hidden" name="otp" id="combinedOtp">
      <button type="submit" class="btn btn-primary w-100 mb-2">Confirm</button>
    </form>
  </div>
</div>

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
  alert('OTP entered: ' + otp);
}
window.addEventListener('load', () => {
  const first = document.querySelector('.otp-input');
  if (first) first.focus();
});
</script>

<style>
.otp-page {
  background-color: #f4f6f9;
}

.otp-card {
  max-width: 460px;
  width: 100%;
  border-radius: 12px;
}

.icon-circle {
  width: 72px;
  height: 72px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(37, 99, 235, 0.12);
}

.otp-input {
  width: 56px;
  height: 56px;
  font-size: 1.5rem;
  border-radius: 8px;
  text-align: center;
}
</style>
@endsection
