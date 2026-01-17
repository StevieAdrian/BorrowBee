<footer style="background-color: #FFB933" class="text-black py-5 mt-5">
    <div class="container">
        <div class="row align-items-start">

            <div class="col-md-4 mb-4 text-center text-md-start">
                <img src="{{ asset('assets/borrowbee-logo-black.png') }}" alt="BorrowBee" style="width: 120px">

                <div class="d-flex gap-3 mt-3 ms-3 align-center justify-content-center justify-content-md-start">
                    <img src="{{ asset('assets/logo-x.png') }}" alt="X" style="width: 20px">
                    <img src="{{ asset('assets/logo-instagram.png') }}" alt="Instagram" style="width: 20px">
                    <img src="{{ asset('assets/logo-youtube.png') }}" alt="Youtube" style="width: 20px">
                </div>
            </div>

            <div class="col-md-4 mb-4 text-start">
                <h5 class="fw-bold mb-3">{{ __('footer.links') }}</h5>

                <ul class="list-unstyled">
                    <li><a href="/" class="text-black text-decoration-none text-start">{{ __('footer.home') }}</a></li>
                    <li><a href="/my-books" class="text-black text-decoration-none">{{ __('footer.my_books') }}</a></li>
                    <li><a href="/about" class="text-black text-decoration-none">{{ __('footer.about') }}</a></li>
                    <li><a href="/contact" class="text-black text-decoration-none">{{ __('footer.contact') }}</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">{{ __('footer.contact_header') }}</h5>

                <p class="mb-1">
                    Address: 128 Maplewood Avenue, Suite 402, Seattle, WA 98121
                </p>
                <p class="mb-3">
                    Phone: +1 (206) 555-4827
                </p>
                @auth
                    <form action="{{ route('contact.send') }}" method="POST"
                          onsubmit="disableContactButton(this)">
                        @csrf

                        <textarea
                            name="message"
                            class="form-control mb-2"
                            rows="3"
                            placeholder="Write your message..."
                            required
                        ></textarea>

                        <button type="submit"
                                class="btn btn-dark btn-sm w-100"
                                id="contactSubmitBtn">
                            Send Message
                        </button>
                    </form>
                @else
                    <small>
                        <a href="{{ route('login') }}"
                           class="text-black text-decoration-underline">
                            Login to send us a message
                        </a>
                    </small>
                @endauth
            </div>
        </div>

        <div class="text-center mt-4">
            <small>© BorrowBee 2025. All Right Reserved.</small>
        </div>
    </div>
</footer>

<script>
    function disableContactButton(form) {
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerText = 'Sending...';
    }
</script>
