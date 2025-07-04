<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tasks - Task App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  .task-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      border: none;
      transition: all 0.3s ease;
      overflow: hidden;
      margin-bottom: 20px;
  }
    
  .task-card .card-body {
      padding: 25px;
  }
    
  .task-card .card-title {
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 15px;
      font-size: 1.2rem;
  }
    
  .task-card .card-text {
      color: #7f8c8d;
      line-height: 1.6;
      margin-bottom: 15px;
  }    
  .main-content{
      background-color: #f0f4f8;
  }
   
</style>
<body>

  <div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-light p-3 shadow" style="width: 220px; min-height: 100vh;" id="sidebar">
      <h5><i class="fas fa-bars me-2"></i> Menu</h5>
      <ul class="nav flex-column mt-3" id="sidebarMenu">
        <li class="nav-item">
          <a class="nav-link" href="/tasks"><i class="fas fa-tasks me-2"></i> Tugas</a>
        </li>
        <!-- Menu Admin akan ditambahkan via JavaScript -->
      </ul>
    </div>

    <div class="flex-grow-1  main-content">
      <div class="container  p-5">
        {{-- Header --}}
        <div class="d-flex flex-column">
          <div class="d-flex justify-content-end">
            <button onclick="logout()" class="btn btn-danger" style="max-width: 120px"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
          </div>
          <h2>Daftar Tugas</h2>
          <p class="text-secondary">Selamat Datang di daftar tugas. Tetap Semangat dalam mengerjakan tugas!</p>
        </div>

        {{-- Tambah Task --}}
        <div class="mt-2 mb-3">
          <button class="btn btn-success" onclick="showAddModal()" id="addTaskBtn" style="display: none;"><i class="fa-solid fa-plus me-2"></i>Tambah Tugas</button>
        </div>

        <!-- Modal Tambah Task -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Tambah Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addTaskForm">
                  <div class="mb-3">
                    <label for="newTitle" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="newTitle" required>
                  </div>
                  <div class="mb-3">
                    <label for="newDescription" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="newDescription" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="newDueDate" class="form-label">Tanggal Deadline</label>
                    <input type="date" class="form-control" id="newDueDate" required>
                  </div>
                  <div class="mb-3">
                    <label for="newAssignedTo" class="form-label">Tugaskan ke</label>
                    <select class="form-select" id="newAssignedTo" required></select>
                  </div>
                  <button type="submit" class="btn btn-success">Tambah</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div id="taskList" class="row gy-3">
          <!-- Data akan ditampilkan di sini -->
        </div>

        <div class="mt-4 mb-4">
          <button onclick="loadTasks()" class="btn btn-primary">Reload</button>
        </div>
      </div>
    </div>
      <!-- Modal Edit Task -->
      <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editTaskModalLabel">Edit Tugas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="editTaskForm">
                <input type="hidden" id="editTaskId">
                <div class="mb-3">
                  <label for="editTitle" class="form-label">Judul</label>
                  <input type="text" class="form-control" id="editTitle" required>
                </div>
                <div class="mb-3">
                  <label for="editDescription" class="form-label">Deskripsi</label>
                  <textarea class="form-control" id="editDescription" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="editDueDate" class="form-label">Tanggal Deadline</label>
                  <input type="date" class="form-control" id="editDueDate" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>

 
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Script Gabung --}}
<script>
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user'));

    if (!token || !user) {
      window.location.href = '/';
    }

    async function loadTasks() {
      const taskList = document.getElementById('taskList');
      const addTaskBtn = document.getElementById('addTaskBtn');

      // Tampilkan atau sembunyikan tombol Add Task berdasarkan role
      if (user.role === 'admin') {
        addTaskBtn.style.display = 'inline-block';
      } else {
        addTaskBtn.style.display = 'none';
      }

      taskList.innerHTML = 
      `<div class="text-muted">Loading...</div>`;

      try {
        const res = await fetch('/api/tasks', {
          headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
          }
        });

        const data = await res.json();

        if (!res.ok) {
          taskList.innerHTML = `<div class="text-danger">${data.message}</div>`;
          return;
        }

        if (data.length === 0) {
          taskList.innerHTML = '<div class="text-muted">Tidak ada tugas.</div>';
          return;
        }

        taskList.innerHTML = '';

        data.forEach(task => {
          let badge = '<span class="badge bg-secondary">Unknown</span>';
          if (task.status === 'done') badge = '<span class="badge bg-success">Selesai</span>';
          else if (task.status === 'pending') badge = '<span class="badge bg-warning text-dark">Pending</span>';
          else if (task.status === 'overdue') badge = '<span class="badge bg-danger">Terlambat</span>';

          taskList.innerHTML += `
            <div class="col-md-4">
              <div class="card task-card shadow rounded" style="height: 100%;">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">${task.title}</h5>
                    ${badge}
                  </div>
                  <p class="card-text">${task.description}</p>
                  <p class="card-text"><i class="fas fa-calendar-alt me-2"></i><small class="text-muted">Deadline: ${task.due_date}</small></p>
                  ${user.role === 'admin' ? `
                    <button class="btn btn-sm btn-outline-warning me-2" onclick="editTask('${task.id}', '${task.title}', '${task.description}', '${task.due_date}')">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteTask('${task.id}')">Delete</button>
                  ` : ''}
                </div>
              </div>
            </div>
          `;
        });
      } catch (err) {
        taskList.innerHTML = '<div class="text-danger">Gagal memuat data.</div>';
      }
    }

    function logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/';
    }

    function showAddModal() {
      if (user.role !== 'admin') {
        alert('Hanya admin yang bisa menambahkan tugas.');
        return;
      }

      const modal = new bootstrap.Modal(document.getElementById('addTaskModal'));
      fetch('/api/users', {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById('newAssignedTo');
        select.innerHTML = '';
        data.forEach(user => {
          if (user.role === 'staff') {
            select.innerHTML += `<option value="${user.id}">${user.name} (${user.email})</option>`;
          }
        });
        modal.show();
      })
      .catch(() => alert('Gagal memuat user'));
    }

    document.getElementById('addTaskForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      if (user.role !== 'admin') {
        alert('Hanya admin yang bisa menambahkan tugas.');
        return;
      }

      const title = document.getElementById('newTitle').value;
      const description = document.getElementById('newDescription').value;
      const due_date = document.getElementById('newDueDate').value;
      const assigned_to = document.getElementById('newAssignedTo').value;

      try {
        const res = await fetch('/api/tasks', {
          method: 'POST',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ title, description, due_date, assigned_to })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal menambahkan task');

        alert('Task berhasil ditambahkan');
        bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
        loadTasks();
      } catch (err) {
        alert(err.message);
      }
    });

    function editTask(id, title, description, dueDate) {
      if (user.role !== 'admin') {
        alert('Hanya admin yang bisa mengedit tugas.');
        return;
      }

      document.getElementById('editTaskId').value = id;
      document.getElementById('editTitle').value = title;
      document.getElementById('editDescription').value = description;
      document.getElementById('editDueDate').value = dueDate;

      const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
      modal.show();
    }

    document.getElementById('editTaskForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      if (user.role !== 'admin') {
        alert('Hanya admin yang bisa menyimpan perubahan.');
        return;
      }

      const id = document.getElementById('editTaskId').value;
      const title = document.getElementById('editTitle').value;
      const description = document.getElementById('editDescription').value;
      const dueDate = document.getElementById('editDueDate').value;

      try {
        const res = await fetch(`/api/tasks/${id}`, {
          method: 'PUT',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ title, description, due_date: dueDate })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal edit tugas');

        alert('Tugas berhasil diubah');
        bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
        loadTasks();
      } catch (err) {
        alert(err.message);
      }
    });

    function deleteTask(id) {
      if (user.role !== 'admin') {
        alert('Hanya admin yang bisa menghapus tugas.');
        return;
      }

      if (confirm('Yakin ingin menghapus task ini?')) {
        fetch(`/api/tasks/${id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message || 'Task dihapus');
          loadTasks();
        })
        .catch(err => alert('Gagal menghapus task'));
      }
    }

    loadTasks();

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

    // Tambahkan menu admin jika role admin
    if (user.role === 'admin') {
      const adminItem = document.createElement('li');
      adminItem.classList.add('nav-item');

      adminItem.innerHTML = `
        <a class="nav-link text-danger" href="/admin">
          <i class="fas fa-user-shield me-2"></i> Panel Admin
        </a>
      `;

      sidebarMenu.appendChild(adminItem);

      // Tandai juga jika menu admin aktif
      if (currentPath === '/admin') {
        adminItem.querySelector('a').classList.add('active');
      }
    }
  });
</script>
</html>
