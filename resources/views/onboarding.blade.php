<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam.in - Onboarding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Left Panel */
        .left-panel {
            background: linear-gradient(135deg, #4FB9C8 0%, #3AA0AE 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 50%;
        }

        .logo-container {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .tagline {
            font-size: 1rem;
            opacity: 0.95;
            text-align: center;
        }

        /* Right Panel */
        .right-panel {
            background: white;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
        }

        .onboarding-content {
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .icon-circle {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #E8F6F8 0%, #D4EEF2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 4px 15px rgba(79, 185, 200, 0.2);
        }

        .icon-circle svg {
            width: 60px;
            height: 60px;
            fill: #4FB9C8;
        }

        .onboarding-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .onboarding-description {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 2.5rem;
        }

        /* Pagination Dots */
        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #E0E0E0;
            transition: all 0.3s ease;
        }

        .dot.active {
            width: 24px;
            border-radius: 4px;
            background: #4FB9C8;
        }

        /* Button */
        .btn-next {
            background: #4FB9C8;
            color: white;
            border: none;
            padding: 0.9rem 2.5rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 185, 200, 0.3);
            width: 100%;
            max-width: 300px;
        }

        .btn-next:hover {
            background: #3AA0AE;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 185, 200, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-panel {
                width: 100%;
                height: 35vh;
                padding: 1.5rem;
            }

            .logo-container {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .logo {
                width: 45px;
                height: 45px;
            }

            .brand-name {
                font-size: 1.5rem;
            }

            .tagline {
                font-size: 0.85rem;
            }

            .right-panel {
                width: 100%;
                height: 65vh;
                padding: 1.5rem;
            }

            .icon-circle {
                width: 100px;
                height: 100px;
                margin-bottom: 1.5rem;
            }

            .icon-circle svg {
                width: 50px;
                height: 50px;
            }

            .onboarding-title {
                font-size: 1.1rem;
            }

            .onboarding-description {
                font-size: 0.85rem;
                margin-bottom: 2rem;
            }

            .btn-next {
                padding: 0.8rem 2rem;
            }
        }

        @media (max-width: 480px) {
            .left-panel {
                height: 30vh;
                padding: 1rem;
            }

            .brand-name {
                font-size: 1.3rem;
            }

            .right-panel {
                height: 70vh;
            }

            .onboarding-title {
                font-size: 1rem;
            }
        }

        /* Fade animation */
        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Pinjam.in Logo">
                </div>
            </div>
            <h1 class="brand-name">Pinjam.in</h1>
            <p class="tagline">Pinjam barang, bangun kepercayaan</p>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="onboarding-content fade-in" id="onboarding-content">
                <!-- Slide 1 -->
                <div class="slide" id="slide-1">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                    </div>
                    <h2 class="onboarding-title">Temukan barang atau buku<br>yang kamu butuhkan</h2>
                    <p class="onboarding-description">Cari berbagai barang dan buku dari komunitas</p>
                </div>

                <!-- Slide 2 (Hidden by default) -->
                <div class="slide" id="slide-2" style="display: none;">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <h2 class="onboarding-title">Pinjam dengan cepat dari<br>sesama mahasiswa</h2>
                    <p class="onboarding-description">Hubungi pemilik barang dengan mudah</p>
                </div>

                <!-- Slide 3 (Hidden by default) -->
                <div class="slide" id="slide-3" style="display: none;">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                        </svg>
                    </div>
                    <h2 class="onboarding-title">Bangun kepercayaan lewat<br>sistem kampus</h2>
                    <p class="onboarding-description">Verifikasi identitas untuk keamanan bersama</p>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <span class="dot active" data-slide="1"></span>
                    <span class="dot" data-slide="2"></span>
                    <span class="dot" data-slide="3"></span>
                </div>

                <!-- Button -->
                <button class="btn-next" onclick="nextSlide()">Selanjutnya →</button>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 1;
        const totalSlides = 3;

        function nextSlide() {
            if (currentSlide < totalSlides) {
                // Hide current slide
                document.getElementById('slide-' + currentSlide).style.display = 'none';
                
                // Update slide number
                currentSlide++;
                
                // Show next slide
                const nextSlideElement = document.getElementById('slide-' + currentSlide);
                nextSlideElement.style.display = 'block';
                nextSlideElement.classList.add('fade-in');
                
                // Update dots
                updateDots();
                
                // Change button text on last slide
                if (currentSlide === totalSlides) {
                    document.querySelector('.btn-next').textContent = 'Mulai →';
                }
            } else {
                // Redirect to main page or role-selection
                window.location.href = '/role-selection'; // Sesuaikan dengan route Laravel Anda
            }
        }

        function updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                if (index + 1 === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Optional: Click on dots to navigate
        document.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', function() {
                const slideNum = parseInt(this.getAttribute('data-slide'));
                if (slideNum !== currentSlide) {
                    document.getElementById('slide-' + currentSlide).style.display = 'none';
                    currentSlide = slideNum;
                    const targetSlide = document.getElementById('slide-' + currentSlide);
                    targetSlide.style.display = 'block';
                    targetSlide.classList.add('fade-in');
                    updateDots();
                    
                    document.querySelector('.btn-next').textContent = 
                        currentSlide === totalSlides ? 'Mulai →' : 'Selanjutnya →';
                }
            });
        });
    </script>
</body>
</html>