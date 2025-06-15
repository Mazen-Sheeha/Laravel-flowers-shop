@extends('front.layouts.app')

@section('title', "SARI'S FLORAL | About us")

@section('content')
    <section class="about-section">
        <div class="heading fade-in">
            <h1>Welcome to Saris Floral</h1>
        </div>

        <div class="about-container">
            <div class="about-image fade-in">
                <img src="{{ asset('images/about_us_image.jpg') }}" alt="Saris Floral Shop Interior" loading="lazy">
            </div>

            <div class="about-content fade-in">
                <h2 class="section-title">Our Story</h2>
                <p>At Saris Floral, we've been bringing floral joy to Melvindale since our founding. Our passion for flowers
                    and commitment to quality have made us a beloved part of the community.</p>
                <div class="location-card">
                    <h2 class="section-title">Visit Us</h2>
                    <div class="address-box">
                        <h3>Saris Floral</h3>
                        <p>18292 Allen Rd</p>
                        <p>Melvindale, MI 48122</p>
                        <p><i class="fas fa-phone"></i>(313) 799-1066</p>
                    </div>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2943.456123456789!2d-83.175987!3d42.281234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b2aef4f9198a5%3A0x1234567890abcdef!2s18292%20Allen%20Rd%2C%20Melvindale%2C%20MI%2048122!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus"
                            width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <div class="map-label">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Saris Floral Location</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <style>
        .about-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-container {
            display: flex;
            gap: 40px;
            margin-top: 40px;
            align-items: center;
        }

        .about-image {
            flex: 1;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .about-content {
            flex: 1;
        }

        .section-title {
            color: var(--main-pink-color);
            font-family: "Montserrat", sans-serif;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .address-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid var(--main-pink-color);
        }

        .address-box h3 {
            color: var(--main-pink-color);
            margin-bottom: 10px;
            font-size: 20px;
        }

        .address-box p {
            margin: 8px 0;
            color: #555;
        }

        .address-box i {
            margin-right: 8px;
            color: var(--main-pink-color);
        }

        .map-container {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .map-label {
            position: absolute;
            top: 15px;
            left: 15px;
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .map-label i {
            color: var(--main-pink-color);
        }

        @media (max-width: 768px) {
            .about-container {
                flex-direction: column;
            }
        }
    </style>
@endsection
