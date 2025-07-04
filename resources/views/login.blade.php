<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Task App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  {{-- Font Poppins --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    * {
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f0f4f8;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background: #fff;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
    }

    .login-card .card-body {
      padding: 30px;
    }

    .login-icon {
      font-size: 40px;
      color: #4c6ef5;
      margin-bottom: 15px;
    }

    .btn-primary:hover {
      background-color: #3b5bdb;
    }

    #errorMessage {
      font-size: 0.9rem;
    }
</style>
<body>
  <div class="login-card card shadow-lg">
    <div class="card-body text-center">
      <div class="login-icon">
        <i class="fas fa-user-circle"></i>
      </div>
      <h4>Selamat Datang</h4>
      <p class="mb-4 text-muted">Silakan login untuk melanjutkan.</p>

      <form id="loginForm" class="text-start">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" required placeholder="you@example.com">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" required placeholder="********">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <div class="mt-3 text-danger" id="errorMessage"></div>
    </div>
  </div>


</body>


<!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');

    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      try {
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
          localStorage.setItem('token', data.token);
          localStorage.setItem('user', JSON.stringify(data.user));
          window.location.href = '/tasks';
        } else {
          errorMessage.textContent = data.message || 'Login gagal';
        }
      } catch (error) {
        errorMessage.textContent = 'Terjadi kesalahan saat login';
      }
    });
  </script>
</html>
