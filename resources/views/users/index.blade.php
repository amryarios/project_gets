@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">User Administration</h2>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel User -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User ID</th>
                        <th>Nama</th>
                        <th>Bagian</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->userid }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>{{ $user->updated_at->format('d-m-Y') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser({{ $user->id }})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="userId">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" id="userName" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Bagian</label>
                        <select name="role_id" id="userRole" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editUser(id) {
        fetch(`/users/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('userId').value = data.id;
                document.getElementById('userName').value = data.name;
                document.getElementById('userRole').value = data.role_id;
                document.getElementById('editUserForm').action = `/users/${data.id}`;
                new bootstrap.Modal(document.getElementById('editUserModal')).show();
            });
    }

    function confirmDelete(id) {
        if (confirm("Yakin ingin menghapus user ini?")) {
            fetch(`/users/${id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
            }).then(() => location.reload());
        }
    }
</script>
@endsection
