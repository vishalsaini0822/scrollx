@extends('layouts.app')

@section('title', 'Templates')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Templates</h2>
            <button class="btn btn-primary" id="addTemplateBtn">Add Template</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Sheet Url</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr data-id="{{ $template->id }}" data-name="{{ $template->template_name }}" data-sheet-url="{{ $template->sheet_url }}" data-image="{{ $template->image }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $template->template_name }}</td>
                        <td><a href="{{ $template->sheet_url }}" target="_blank">View</a></td>
                        <td>
                            @if($template->image)
                                <img src="{{ asset($template->image) }}" alt="Template Image" width="60">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm editTemplateBtn">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm deleteTemplateBtn" data-template-id="{{ $template->id }}" data-template-name="{{ $template->template_name }}">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No template found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($templates, 'links'))
            {{ $templates->links() }}
        @endif
    </div>

    <!-- Add/Edit Template Modal -->
    <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="templateForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="templateId">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="templateModalLabel">Add Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    <div class="mb-3">
                        <label for="templateName" class="form-label text-black" >Name</label>
                        <input type="text" class="form-control" id="templateName" name="template_name">
                        <div class="invalid-feedback" id="templateNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="templateImage" class="form-label text-black" >Image</label>
                        <input type="file" class="form-control" id="templateImage" name="image" accept="image/*">
                        <div class="invalid-feedback" id="templateImageError"></div>
                        <img id="imagePreview" src="#" alt="Image Preview" class="mt-2" style="display:none; max-width:100px;">
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveTemplateBtn">Save</button>
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