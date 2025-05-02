<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Productes</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <header style="display: flex; justify-content: end; align-items: center; padding: 1rem; background-color: #f5f5f5;">
        <button id="logout-btn" style="padding: 0.5rem 1rem; background-color: #e53935; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Logout
        </button>
    </header>
    
    <h1>Llistat de productes</h1>

    <div id="app">
        <product-table></product-table>
    </div>

    <!-- Añadimos un script para el boton logout, que cierre
     sesión, reidirgiendo a la ruta api/logout -->
     <script>
        document.getElementById('logout-btn').addEventListener('click', async () => {
            const token = localStorage.getItem('token');

            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {
                console.error('Logout local només, no es va notificar al servidor:', e);
            }

            localStorage.removeItem('token');
            localStorage.removeItem('role');
            window.location.href = '/login';
        });
    </script>
</body>
</html>
