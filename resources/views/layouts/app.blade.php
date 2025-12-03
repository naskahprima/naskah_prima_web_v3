<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Primary Meta Tags -->
    <title>@yield('title', $settings['site_name'] ?? 'Naskah Prima') - Jasa Publikasi Jurnal SINTA Informatika</title>
    <meta name="title" content="@yield('meta_title', ($settings['site_name'] ?? 'Naskah Prima') . ' - Jasa Publikasi Jurnal SINTA Informatika')">
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? 'Jasa publikasi jurnal SINTA untuk mahasiswa informatika. 100% bayar SETELAH LOA keluar.')">
    <meta name="keywords" content="@yield('meta_keywords', 'jasa publikasi jurnal, publikasi jurnal SINTA, jasa jurnal informatika')">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Naskah Prima' }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', ($settings['site_name'] ?? 'Naskah Prima') . ' - Jasa Publikasi Jurnal SINTA')">
    <meta property="og:description" content="@yield('og_description', $settings['meta_description'] ?? '')">
    <meta property="og:image" content="@yield('og_image', asset('assets/og-image.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', ($settings['site_name'] ?? 'Naskah Prima') . ' - Jasa Publikasi Jurnal SINTA')">
    <meta property="twitter:description" content="@yield('twitter_description', $settings['meta_description'] ?? '')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('assets/twitter-image.jpg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @stack('styles')

    <!-- JSON-LD Schema Markup for SEO -->
    @yield('schema')
</head>
<body>
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('components.footer')

    <!-- Floating WhatsApp Button -->
    @include('components.whatsapp-float')

    <!-- Main JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
