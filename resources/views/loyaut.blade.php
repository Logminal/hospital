<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
    <script>
        (function () {
            try {
                if (localStorage.getItem('accessible-mode') === 'on') {
                    document.documentElement.classList.add('accessible-mode');
                }
            } catch (e) {}
        })();
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script>
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#137fec",
                "background-light": "#f6f7f8",
                "background-dark": "#101922",
              },
              fontFamily: {
                "display": ["Manrope", "sans-serif"]
              },
              borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
              },
            },
          },
        }
    </script>
    <style>
        .material-symbols-outlined {
          font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
    <button
        type="button"
        class="accessible-toggle"
        id="accessibleModeToggle"
        aria-pressed="false"
        aria-label="Включить версию для слабовидящих"
    >
        <span class="material-symbols-outlined" aria-hidden="true">visibility</span>
        <span id="accessibleModeLabel">Версия для слабовидящих</span>
    </button>
    @yield("main")
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        (function () {
            const toggle = document.getElementById('accessibleModeToggle');
            const label = document.getElementById('accessibleModeLabel');
            const root = document.documentElement;

            if (!toggle || !label) {
                return;
            }

            function applyState(enabled) {
                root.classList.toggle('accessible-mode', enabled);
                toggle.setAttribute('aria-pressed', enabled ? 'true' : 'false');
                toggle.setAttribute('aria-label', enabled ? 'Выключить версию для слабовидящих' : 'Включить версию для слабовидящих');
                label.textContent = enabled ? 'Обычная версия' : 'Версия для слабовидящих';
            }

            let enabled = false;

            try {
                enabled = localStorage.getItem('accessible-mode') === 'on';
            } catch (e) {
                enabled = root.classList.contains('accessible-mode');
            }

            applyState(enabled);

            toggle.addEventListener('click', function () {
                enabled = !root.classList.contains('accessible-mode');
                applyState(enabled);

                try {
                    localStorage.setItem('accessible-mode', enabled ? 'on' : 'off');
                } catch (e) {}
            });
        })();
    </script>
</body>
</html>
