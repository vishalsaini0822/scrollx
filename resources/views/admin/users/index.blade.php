@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Users</h2>
            <button class="btn btn-primary" id="addUserBtn">Add User</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editUserBtn">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm deleteUserBtn" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($users, 'links'))
            {{ $users->links() }}
        @endif
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="userForm">
            @csrf
            <input type="hidden" name="id" id="userId">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="userName" class="form-label text-black">Name</label>
                      <input type="text" class="form-control" id="userName" name="name">
                      <div class="invalid-feedback" id="nameError"></div>
                  </div>
                  <div class="mb-3">
                      <label for="userEmail" class="form-label text-black">Email</label>
                      <input type="email" class="form-control" id="userEmail" name="email">
                      <div class="invalid-feedback" id="emailError"></div>
                  </div>
                  <div class="mb-3" id="passwordField">
                      <label for="userPassword" class="form-label text-black">Password</label>
                      <input type="password" class="form-control" id="userPassword" name="password">
                      <div class="invalid-feedback" id="passwordError"></div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveUserBtn">Save</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center">
            <h5 class="mb-3" id="successModalLabel">Success!</h5>
            <p id="successMessage"></p>
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush