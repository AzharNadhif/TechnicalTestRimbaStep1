<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
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
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow-x: hidden;
    }
    .wrapper {
      display: flex;
      height: 100vh;
    }
    #sidebar {
      width: 220px;
      background-color: #f8f9fa;
      padding: 1rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .nav-link.active {
      background-color: #e7f1ff;
      color: #0d6efd !important;
      font-weight: 500;
      border-radius: 0.375rem;
      border-right: #0d6efd 3px solid;
    }

    .main-content {
      flex-grow: 1;
      padding: 2rem;
      overflow-y: auto;
      background-color: #f0f4f8;
    }
    .badge.text-white {
      text-transform: capitalize;
    }
</style>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="bg-light p-3 shadow-lg" style="width: 220px; min-height: 100vh;" id="sidebar">
      <h5><i class="fas fa-bars me-2"></i> Menu</h5>
      <ul class="nav flex-column mt-3" id="sidebarMenu">
        <li class="nav-item">
          <a class="nav-link" href="/tasks"><i class="fas fa-tasks me-2"></i> Tugas</a>
        </li>
        <!-- Menu Admin akan ditambahkan via JavaScript -->
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h2>Kelola User</h2>
        <button class="btn btn-success" onclick="showUserModal()"><i class="fa-solid fa-plus me-2"></i>Tambah User</button>
      </div>
      <p class="text-muted mb-4">Kelola pengguna di sini.</p>

      <!-- Modal Tambah User -->
      <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form id="userForm" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="userModalLabel">Tambah User Baru</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" required>
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" required>
                  <option value="staff">Staff</option>
                  <option value="manager">Manager</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" required>
                  <option value="1">Aktif</option>
                  <option value="0">Nonaktif</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tabel User -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
            <tr><td colspan="4" class="text-muted text-center">Loading...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Script Gabung --}}
<script>
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user'));

    if (!token || !user || user.role !== 'admin') {
      window.location.href = '/';
    }

    function getRoleClass(role) {
      switch (role) {
        case 'admin': return 'bg-success';
        case 'manager': return 'bg-danger';
        case 'staff': return 'bg-primary';
        default: return '';
      }
    }

    function showUserModal() {
      document.getElementById('userForm').reset();
      new bootstrap.Modal(document.getElementById('userModal')).show();
    }

    document.getElementById('userForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const role = document.getElementById('role').value;
      const status = document.getElementById('status').value;

      try {
        const res = await fetch('/api/users', {
          method: 'POST',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ name, email, password, role, status })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal tambah user');

        alert('User berhasil ditambahkan');
        bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        loadUsers();
      } catch (err) {
        alert(err.message);
      }
    });

    async function loadUsers() {
      const tbody = document.getElementById('userTableBody');
      tbody.innerHTML = '<tr><td colspan="4" class="text-muted text-center">Loading...</td></tr>';

      try {
        const res = await fetch('/api/users', {
          headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
          }
        });
        const users = await res.json();

        if (!res.ok) throw new Error(users.message || 'Gagal ambil user');
        if (users.length === 0) {
          tbody.innerHTML = '<tr><td colspan="4" class="text-muted text-center">Belum ada user.</td></tr>';
          return;
        }

        tbody.innerHTML = '';
        users.forEach(u => {
          tbody.innerHTML += `
            <tr>
              <td>${u.name}</td>
              <td>${u.email}</td>
              <td><span class="badge text-white ${getRoleClass(u.role)}">${u.role}</span></td>
              <td>${u.status ? 'Aktif' : 'Nonaktif'}</td>
            </tr>`;
        });
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-danger text-center">${err.message}</td></tr>`;
      }
    }

    loadUsers();
</script>
{{-- Script Sidebar --}}
<script>
    window.addEventListener('DOMContentLoaded', () => {
      const sidebarMenu = document.getElementById('sidebarMenu');
      const currentPath = window.location.pathname;

      // Tandai nav-link aktif
      document.querySelectorAll('#sidebarMenu .nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('active');
        }
      });

      // Tambahkan Panel Admin jika admin
      if (user.role === 'admin') {
        const adminItem = document.createElement('li');
        adminItem.classList.add('nav-item');

        adminItem.innerHTML = `
          <a class="nav-link text-danger" href="/admin">
            <i class="fas fa-user-shield me-2"></i> Panel Admin
          </a>
        `;

        sidebarMenu.appendChild(adminItem);

        // Tandai juga Panel Admin jika sedang aktif
        const adminLink = adminItem.querySelector('a');
        if (currentPath === '/admin') {
          adminLink.classList.add('active');
        }
      }
    });
</script>
</html>
