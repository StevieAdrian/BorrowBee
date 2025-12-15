@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/aboutUs.css') }}">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@section('content')

    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <div class="container my-5">
        
        <section class="row section-padding hero-section align-items-center pb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                <p class="text-muted small fw-semibold">{{ __('about.discover_journey') }}</p>
                <h1 class="hero-title mb-4">
                    {{ __('about.header_dedicated_to') }} <span class="text-primary-bee">{{ __('about.header_literacy') }}</span> & 
                    {{ __('about.header_inclusive') }} <span class="text-primary-bee">{{ __('about.header_access') }}</span>.
                </h1>
                <p class="lead text-secondary">
                    {{ __('about.paragraph_hero_start') }} <strong>{{ __('about.ebook_services') }}</strong>, {{ __('about.paragraph_hero_end') }}
                </p>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="image-placeholder-box shadow-lg">
                    <div class="image-hover-container">
                        <img src="{{ asset('assets/literacy-illustration.jpg') }}" alt="Digital Literacy Illustration" class="img-fluid image-original">
                        
                        <div class="image-overlay">
                            <p class="overlay-text">{{ __('about.illustration_caption_1') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-5 border-warning opacity-25"> 

        <section class="row section-padding pt-0 align-items-center">
            
            <div class="col-lg-8 mb-4 mb-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-duration="1000">
                <p class="text-primary-bee fw-semibold text-uppercase small mb-1">{{ __('about.mission_core_title') }}</p>
                <h2 class="mb-4 display-6 fw-bold">{{ __('about.mission_q_why') }}</h2>
                <p class="text-secondary fs-6">
                    {{ __('about.mission_p1_start') }}
                </p>
                <p class="text-secondary fs-6">
                    <strong>BorrowBee</strong> {{ __('about.mission_p2_end') }}
                </p>
            </div>

            <div class="col-lg-4 order-1 order-lg-2" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                <div class="stats-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div class="stat-item border-bottom pb-3 mb-3">
                        <span class="stat-number">200K+</span>
                        <p class="stat-text text-muted fw-semibold mb-0">{{ __('about.stat_active_readers') }}</p>
                    </div>
                    <div class="review-card p-3 my-3 shadow-sm">
                        <span class="text-primary-bee fs-5">★★★★★</span>
                        <p class="text-dark mb-1 small fst-italic">{{ __('about.review_quote') }}</p>
                        <div class="text-muted small text-end fw-light">{{ __('about.review_author') }}</div>
                    </div>
                    <div class="stat-item border-top pt-3 mt-3">
                        <span class="stat-number">SDG 4</span>
                        <p class="stat-text text-muted fw-semibold mb-0">{{ __('about.stat_sdg_contributor') }}</p>
                    </div>
                </div>
            </div>
        </section>
        
        <hr class="my-5 border-warning opacity-25"> 

        <section class="row section-padding pt-0 align-items-center flex-row-reverse">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-left" data-aos-duration="1000">
                <p class="text-primary-bee fw-semibold text-uppercase small mb-1">{{ __('about.values_title') }}</p>
                <h2 class="mb-4 display-6 fw-bold">{{ __('about.values_header') }}</h2>
                <ul class="features-list">
                    <li data-aos="fade-left" data-aos-delay="100">
                        <div class="feature-icon-wrapper"><span class="iconify text-primary-bee" data-icon="cil:dollar"></span></div>
                        <strong>{{ __('about.feature_1_title') }}:</strong> {{ __('about.feature_1_desc') }}.
                    </li>
                    <li data-aos="fade-left" data-aos-delay="200">
                        <div class="feature-icon-wrapper"><span class="iconify text-primary-bee" data-icon="material-symbols:lock-open-right"></span></div>
                        <strong>{{ __('about.feature_2_title') }}:</strong> {{ __('about.feature_2_desc') }}.
                    </li>
                    <li data-aos="fade-left" data-aos-delay="300">
                        <div class="feature-icon-wrapper"><span class="iconify text-primary-bee" data-icon="mdi:account-key"></span></div>
                        <strong>{{ __('about.feature_3_title') }}:</strong> {{ __('about.feature_3_desc') }}.
                    </li>
                    <li data-aos="fade-left" data-aos-delay="400">
                        <div class="feature-icon-wrapper"><span class="iconify text-primary-bee" data-icon="ic:baseline-devices"></span></div>
                        <strong>{{ __('about.feature_4_title') }}:</strong> {{ __('about.feature_4_desc') }}.
                    </li>
                    <li data-aos="fade-left" data-aos-delay="500">
                        <div class="feature-icon-wrapper"><span class="iconify text-primary-bee" data-icon="material-symbols:school"></span></div>
                        <strong>{{ __('about.feature_5_title') }}:</strong> {{ __('about.feature_5_desc') }}.
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <div class="image-placeholder-box shadow-lg">
                    <div class="image-hover-container">
                        <img src="{{ asset('assets/feature-illustration.jpg') }}" alt="Feature Illustration" class="img-fluid image-original">
                        
                        <div class="image-overlay">
                            <p class="overlay-text">{{ __('about.illustration_caption_2') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="team-section section-padding">
            <p class="text-primary-bee fw-semibold text-uppercase small mb-1">{{ __('about.team_title') }}</p>
            <h2 class="mb-2 display-6 fw-bold">{{ __('about.team_header') }}</h2>
            <p class="text-secondary mb-5">{{ __('about.team_description') }}</p>

            <div class="row justify-content-center">
                
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-member" data-aos="flip-up" data-aos-delay="100">
                    <div class="portrait-container">
                        <img src="{{ asset('assets/keane-mclaren.JPG') }}" alt="Keane Mclaren Lee Photo" class="team-portrait">
                    </div>
                    <h5 class="mb-0 fw-bold">Keane Mclaren Lee</h5>
                    <div class="social-links">
                        <a href="https://id.linkedin.com/in/keane-mclaren-lee"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                        <a href="https://github.com/KeaneMclaren"><span class="iconify" data-icon="mdi:github"></span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-member" data-aos="flip-up" data-aos-delay="200">
                    <div class="portrait-container">
                        <img src="{{ asset('assets/stevie-adrian.jpeg') }}" alt="Stevie Adrian Photo" class="team-portrait">
                    </div>
                    <h5 class="mb-0 fw-bold">Stevie Adrian</h5>
                    <div class="social-links">
                        <a href="https://id.linkedin.com/in/stevie-adrian"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                        <a href="https://github.com/StevieAdrian"><span class="iconify" data-icon="mdi:github"></span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-member" data-aos="flip-up" data-aos-delay="300">
                    <div class="portrait-container">
                        <img src="{{ asset('assets/rendy-ciang.jpeg') }}" alt="Rendy Ciang Photo" class="team-portrait">
                    </div>
                    <h5 class="mb-0 fw-bold">Rendy Ciang</h5>
                    <div class="social-links">
                        <a href="https://id.linkedin.com/in/rendy-ciang-879817292"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                        <a href="https://github.com/RendyCiang"><span class="iconify" data-icon="mdi:github"></span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-member" data-aos="flip-up" data-aos-delay="400">
                    <div class="portrait-container">
                        <img src="{{ asset('assets/shania-sukandar.jpeg') }}" alt="Shania Sukandar Photo" class="team-portrait">
                    </div>
                    <h5 class="mb-0 fw-bold">Shania Sukandar</h5>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/sshania-sukandar?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                        <a href="https://github.com/sshania"><span class="iconify" data-icon="mdi:github"></span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-member" data-aos="flip-up" data-aos-delay="500">
                    <div class="portrait-container">
                        <img src="{{ asset('assets/nicole-alexandra-yauwrentius.JPG') }}" alt="Nicole Alexandra Yauwrentius Photo" class="team-portrait">
                    </div>
                    <h5 class="mb-0 fw-bold">Nicole Alexandra Yauwrentius</h5>
                    <div class="social-links">
                        <a href="http://www.linkedin.com/in/nicole-alexandra-yauwrentius-561735298"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                        <a href="https://github.com/Nicole-yauwrentius"><span class="iconify" data-icon="mdi:github"></span></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
          once: true,
      });
    </script>
@endsection