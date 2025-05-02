<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="login-container">
        <h1>INICIAR SESSIÓ</h1>

        <form id="login-form">
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <!-- Mensaje error si las credenciales no son correctos -->
        <p id="error-msg" style="color:red; display:none;">Credencials incorrectes</p>
    </div>

    <!-- Axios via CDN (sin module, sin import) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Script funcional -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('login-form');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const email = form.email.value;
                const password = form.password.value;

                try {
                    const response = await axios.post('/api/login', {
                        email,
                        password
                    });

                    console.log('LOGIN OK', response.data);

                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('role', response.data.role);

                    window.location.href = '/products';
                } catch (err) {
                    console.error('Login ERROR:', err);
                    alert('Login incorrecte');
                }
            });
        });
    </script>
</body>
</html>
