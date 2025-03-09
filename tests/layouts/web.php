<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Go PHP captcha' ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/go-captcha-jslib@1.0.9/dist/gocaptcha.global.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Go PHP Captcha</h1>
        <p class="subtitle">An complete Go-Captcha integration for php developers, adapted to make a modern fancy and protected web.</p>
    </header>
    <main>
        <section class="demo-section">
            <?= $data['content']; ?>
        </section>

        <section class="features">
            <h2>Features</h2>
            <div class="features-grid">
                <div class="feature">
                    <h3>Simple</h3>
                    <p>Designed for easy implementations on your web projects</p>
                </div>
                <div class="feature">
                    <h3>Fast Development</h3>
                    <p>Set your captcha images in 4 code lines.</p>
                </div>
                <div class="feature">
                    <h3>Ligthweight</h3>
                    <p>Minimal third party, keep your project clean </p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>Made with love ❤️ and PHP 🐘</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/go-captcha-jslib@1.0.9/dist/gocaptcha.global.min.js"></script>
    <?= $data['js'] ?? ''; ?>
</body>
</html>