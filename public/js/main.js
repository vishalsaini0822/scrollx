$(document).ready(function(){
    $(".mobile-menu").click(function() {
        $(".header-menu").toggleClass("menuactive");
    });
});


// Dashboard js 
function selectEndCreditType(type) {
    $('#end_credits_type').val(type);
    if (type === 'scrolling') {
        $('#modal-title-id').text('Create Scroll Project');
        $('#scrollingBtn').css({
            'color': '#fff',
            'background': '#23232b'
        });
        $('#staticCardsBtn').css({
            'color': '#bbaaff',
            'background': 'none'
        });
        $('#resolution-group').hide();
    } else {
        $('#modal-title-id').text('Create Card Project');
        $('#scrollingBtn').css({
            'color': '#bbaaff',
            'background': 'none'
        });
        $('#staticCardsBtn').css({
            'color': '#fff',
            'background': '#23232b'
        });
        $('#resolution-group').show();
    }
}

function selectTemplate(value) {
    $('#form-template-id').val(value);
    $('#save_template').modal('show');
}
function showContent(tabId) {
    document.querySelectorAll('.content-block').forEach(el => el.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';

    document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}

$(document).ready(function() {
    // Set default end credit type
    selectEndCreditType('scrolling');

    // Project slider
    $('.project-slider').slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true
    });

    // Status change AJAX
    $('.status-dropdown').change(function() {
        var row = $(this).closest('tr');
        var projectId = row.data('project-id');
        var newStatus = $(this).val();
        $.ajax({
            url: '/update-project-status',
            method: 'POST',
            data: {
                project_id: projectId,
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                row.find('.status-dropdown').val(newStatus);
                row.css('background', '#2d3a2d');
                setTimeout(function() {
                    row.css('background', '#23232b');
                }, 800);
            },
            error: function() {
                showErrorModal();
            }
        });
    });

    // Edit
    $('.edit-project, .edit-project-btn').click(function() {
        var row = $(this).closest('tr');
        var projectId = row.data('project-id');
        $.ajax({
            url: '/projects/' + projectId + '/edit',
            method: 'GET',
            success: function(response) {
                $('#save_template .modal-title').text('Rename Scroll Project');
                $('#template_name').val(response.template_name || '');
                $('#end_credits_type').val(response.end_credits_type || 'scrolling');
                if (response.end_credits_type === 'static_cards') {
                    selectEndCreditType('static_cards');
                    $('#resolution').val(response.resolution || '');
                } else {
                    selectEndCreditType('scrolling');
                }
                $('#createProjectForm button[type="submit"]').text('Update');
                $('#form-project-id').val(projectId);
                $('#save_template').modal('show');
            },
            error: function() {
                showErrorModal();
            }
        });
    });

    // Intercept form submit for update
    $('#createProjectForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        var valid = true;
        var name = $('#template_name').val().trim();
        var type = $('#end_credits_type').val();
        var resolution = $('#resolution').val();
        var projectId = $('#form-project-id').val();
        var templateId = $('#form-template-id').val();

        $('#nameError').hide();
        $('#resolutionError').hide();

        if (name.length < 3) {
            $('#nameError').text('Project name must be at least 3 characters.').show();
            valid = false;
        }
        if (type === 'static_cards' && !resolution) {
            $('#resolutionError').text('Please select a resolution.').show();
            valid = false;
        }
        if (!valid) return;

        var url = '/store-project';
        var method = 'POST';
        var data = {
            template_name: name,
            end_credits_type: type,
            template_id: templateId,
            resolution: (type === 'static_cards' ? resolution : ''),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        if (projectId) {
            url = '/projects/' + projectId;
            method = 'PUT';
            data.project_id = projectId;
        }

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function() {
                $('#save_template').modal('hide');
                showSuccessModal();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.template_name) {
                        $('#nameError').text(xhr.responseJSON.errors.template_name[0]).show();
                    }
                    if (xhr.responseJSON.errors.resolution) {
                        $('#resolutionError').text(xhr.responseJSON.errors.resolution[0]).show();
                    }
                }
            }
        });
    });

    // Reset modal on close
    $('#save_template').on('hidden.bs.modal', function () {
        $('#createProjectForm').removeData('project-id');
        $('#createProjectForm')[0].reset();
        $('#createProjectForm button[type="submit"]').text('Create');
        selectEndCreditType('scrolling');
        $('#nameError').hide();
        $('#resolutionError').hide();
    });

    // Copy
    $('.copy-project').click(function() {
        var row = $(this).closest('tr');
        var projectId = row.data('project-id');
        var projectName = row.find('td:first').text().trim();

        $('#duplicateProjectModal').remove();

        $('body').append(`
            <div class="modal fade" id="duplicateProjectModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                        <div class="modal-header" style="border-bottom:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:1;">&times;</button>
                        </div>
                        <div class="modal-body" style="padding:32px 24px;">
                            <div style="display:flex; flex-direction:column; align-items:center;">
                                <div style="font-size:28px; font-weight:700; margin-bottom:24px;">Duplicate Project</div>
                                <div style="font-size:16px; margin-bottom:12px; text-align:left; width:100%; max-width:400px;">
                                    Enter a new name for the copied project:
                                </div>
                                <div style="width:100%; max-width:400px; text-align:left; margin-bottom:8px;">
                                <input type="text" id="duplicateProjectName" class="form-control" placeholder="Name" value="" style="background:#18181f; color:#fff; border:1px solid #444; border-radius:8px; margin-bottom:4px; width:100%; max-width:400px; text-align:left; transition: border 0.2s;" />
                                <span id="duplicateNameError" style="color:#ff7675; display:none; margin-bottom:20px; margin-top:2px; text-align:left; width:100%; font-size:14px;"></span></div>
                                <div style="display:flex; justify-content:center; gap:24px;">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" style="background:none; color:#fff; border:1px solid #444; border-radius:8px; padding:8px 32px;">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirmDuplicateBtn" style="background:#6c5ce7; border:none; border-radius:8px; padding:8px 32px;">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);

        $('#duplicateProjectModal').modal('show');

        $('#confirmDuplicateBtn').off('click').on('click', function() {
            var newName = $('#duplicateProjectName').val().trim();
            $('#duplicateNameError').hide();
            if (newName.length < 3) {
                $('#duplicateNameError').text('Project name must be at least 3 characters.').show();
                $('#duplicateProjectName').css('border', '1.5px solid #ff7675');
                return;
            } else {
                $('#duplicateProjectName').css('border', '1px solid #444');
            }
            $.ajax({
                url: '/projects/' + projectId + '/copy',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    template_name: newName
                },
                success: function() {
                    $('#duplicateProjectModal').modal('hide');
                    showSuccessModal();
                },
                error: function(xhr) {
                    $('#duplicateProjectModal').modal('hide');
                    showErrorModal();
                }
            });
        });
    });

    // Render
    $('.render-project').click(function() {
        var row = $(this).closest('tr');
        var projectId = row.data('project-id');
        window.location.href = '/projects/' + projectId + '/render';
    });

    // Delete
    $('.delete-project').click(function() {
        var row = $(this).closest('tr');
        var projectId = row.data('project-id');
        var projectName = row.find('td:first').text().trim();

        $('#deleteConfirmModal').remove();

        $('body').append(`
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                        <div class="modal-header" style="border-bottom:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:1;">&times;</button>
                        </div>
                        <div class="modal-body" style="padding:32px 24px;">
                            <div style="font-size:24px; font-weight:700; margin-bottom:10px;">Are you sure!</div>
                            <div style="font-size:16px; margin-bottom:20px;">
                                You want to delete project<br>
                                (<span style="color:#bbaaff;">${$('<div>').text(projectName).html()}</span>)?
                            </div>
                            <div style="display:flex; justify-content:center; gap:16px;">
                                <button type="button" class="btn btn-default" data-dismiss="modal" style="background:none; color:#fff; border:1px solid #444; border-radius:8px; padding:8px 24px;">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmDeleteBtn" style="background:#6c5ce7; border:none; border-radius:8px; padding:8px 32px;">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);

        $('#deleteConfirmModal').modal('show');

        $('#confirmDeleteBtn').off('click').on('click', function() {
            $.ajax({
                url: '/projects/' + projectId,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $('#deleteConfirmModal').modal('hide');
                    row.remove();
                    showDeleteSuccessModal();
                },
                error: function() {
                    $('#deleteConfirmModal').modal('hide');
                    showErrorModal();
                }
            });
        });
    });

    function showErrorModal() {
        if ($('#deleteErrorModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="deleteErrorModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                            <div class="modal-body" style="padding:32px 24px;">
                                <div style="font-size:24px; font-weight:700; margin-bottom:16px;">
                                    Something went wrong.<br>Please try again.
                                </div>
                                <button type="button" class="btn btn-primary" id="closeDeleteErrorModal" style="background:#6c5ce7; border:none; border-radius:8px; padding:8px 32px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        $('#deleteErrorModal').modal('show');
        $('#closeDeleteErrorModal').off('click').on('click', function() {
            $('#deleteErrorModal').modal('hide');
        });
    }

    function showSuccessModal() {
        if ($('#successModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                            <div class="modal-body" style="padding:32px 24px;">
                                <span style="font-size:32px;">✅</span>
                                <div style="margin-top:12px; font-size:18px;">Project saved successfully!</div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        $('#successModal').modal('show');
        setTimeout(function() {
            $('#successModal').modal('hide');
            location.reload();
        }, 3000);
    }

    function showDeleteSuccessModal() {
        if ($('#deleteSuccessModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="deleteSuccessModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                            <div class="modal-body" style="padding:32px 24px;">
                                <div style="font-size:24px; font-weight:700; margin-bottom:16px;">
                                    Project has been<br> deleted successfully.
                                </div>
                                <button type="button" class="btn btn-primary" id="closeDeleteSuccessModal" style="background:#6c5ce7; border:none; border-radius:8px; padding:8px 32px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        $('#deleteSuccessModal').modal('show');
        $('#closeDeleteSuccessModal').off('click').on('click', function() {
            $('#deleteSuccessModal').modal('hide');
        });
    }
});






// user list js
// User Modal Functionality with Browser Validation, Dynamic Heading, and Input Labels
$(function() {
    var userModal = null, successModal = null, errorModal = null;
    if (document.getElementById('userModal')) {
        userModal = new bootstrap.Modal(document.getElementById('userModal'));
    }
    if (document.getElementById('successModal')) {
        successModal = new bootstrap.Modal(document.getElementById('successModal'));
    }
    if (document.getElementById('errorModal')) {
        errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    }

    // Add input labels dynamically (if not present)
    if ($('#userName').prev('label').length === 0) {
        $('#userName').before('<label for="userName" class="form-label" style="color:#23232b;">Name</label>');
    }
    if ($('#userEmail').prev('label').length === 0) {
        $('#userEmail').before('<label for="userEmail" class="form-label" style="color:#23232b;">Email</label>');
    }
    if ($('#userPassword').prev('label').length === 0) {
        $('#userPassword').before('<label for="userPassword" class="form-label" style="color:#23232b;">Password</label>');
    }

    // Open Add User Modal
    $('#addUserBtn').on('click', function() {
        $('#userModalLabel').css('color','black').text('Add User');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#passwordField').show();
        $('#userName').attr('placeholder', 'Enter name');
        $('#userEmail').attr('placeholder', 'Enter email');
        $('#userPassword').attr('placeholder', 'Enter password');
        clearValidation();
        userModal.show();
    });

    // Open Edit User Modal
    $('.editUserBtn').on('click', function() {
        var row = $(this).closest('tr');
        $('#userModalLabel').css('color','black').text('Edit User');
        $('#userId').val(row.data('id'));
        $('#userName').val(row.data('name'));
        $('#userEmail').val(row.data('email'));
        $('#userPassword').val('');
        $('#passwordField').hide();
        clearValidation();
        userModal.show();
    });

    // Clear validation errors
    function clearValidation() {
        $('#userForm input').removeClass('is-invalid');
        $('#nameError, #emailError, #passwordError').text('');
    }

    // Clear validation message on input focus
    $('#userName').on('input focus', function() {
        $(this).removeClass('is-invalid');
        $('#nameError').text('');
    });
    $('#userEmail').on('input focus', function() {
        $(this).removeClass('is-invalid');
        $('#emailError').text('');
    });
    $('#userPassword').on('input focus', function() {
        $(this).removeClass('is-invalid');
        $('#passwordError').text('');
    });

    // Browser-side validation
    function validateUserForm(isEdit) {
        var valid = true;
        var name = $('#userName').val().trim();
        var email = $('#userEmail').val().trim();
        var password = $('#userPassword').val();
        clearValidation();

        // Name validation
        if (name.length < 3) {
            $('#userName').addClass('is-invalid');
            $('#nameError').text('Name must be at least 3 characters.');
            valid = false;
        }

        // Email validation
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            $('#userEmail').addClass('is-invalid');
            $('#emailError').text('Please enter a valid email address.');
            valid = false;
        }

        // Password validation (only for add)
        if (!isEdit && password.length < 6) {
            $('#userPassword').addClass('is-invalid');
            $('#passwordError').text('Password must be at least 6 characters.');
            valid = false;
        }

        return valid;
    }

    // AJAX form submit with browser validation
    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        var isEdit = !!$('#userId').val();
        if (!validateUserForm(isEdit)) return;

        var id = $('#userId').val();
        var url = id ? '/users/' + id : '/users';
        var data = $(this).serialize();
        if (id) {
            data += '&_method=PUT';
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function() {
                userModal.hide();
                $('#successMessage').css('color','black').text(isEdit ? 'User updated successfully!' : 'User added successfully!');
                successModal.show();
                setTimeout(function() { location.reload(); }, 1500);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON) {
                    var errors = xhr.responseJSON.errors || {};
                    var hasFieldError = false;
                    if (errors.name) {
                        $('#userName').addClass('is-invalid');
                        $('#nameError').text(errors.name[0]);
                        hasFieldError = true;
                    }
                    if (errors.email) {
                        $('#userEmail').addClass('is-invalid');
                        $('#emailError').text(errors.email[0]);
                        hasFieldError = true;
                    }
                    if (errors.password) {
                        $('#userPassword').addClass('is-invalid');
                        $('#passwordError').text(errors.password[0]);
                        hasFieldError = true;
                    }
                    if (!hasFieldError && xhr.responseJSON.message) {
                        $('#errorMessage').text(xhr.responseJSON.message);
                        userModal.hide();
                        errorModal.show();
                    }
                } else {
                    $('#errorMessage').text('Failed to save user. Please try again.');
                    userModal.hide();
                    errorModal.show();
                }
            }
        });
    });

    $('.deleteUserBtn').on('click', function() {
        var row = $(this).closest('tr');
        var userId = row.data('id');
        var userName = row.data('name');
        $('#deleteUserModal').remove();
        $('body').append(`
            <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">         
                    <div class="modal-content" style="background:#23232b; color:#fff; border-radius:12px; text-align:center;">
                        <div class="modal-header" style="border-bottom:none;">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1); opacity:1;"></button>
                        </div>
                        <div class="modal-body" style="padding:32px 24px;">
                            <div style="font-size:24px; font-weight:700; margin-bottom:10px;">Are you sure!</div>
                            <div style="font-size:16px; margin-bottom:20px;">
                                You want to delete user<br>
                                (<span style="color:#bbaaff;">${$('<div>').text(userName).html()}</span>)?
                            </div>
                            <div style="display:flex; justify-content:center; gap:16px;">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal" style="background:none; color:#fff; border:1px solid #444; border-radius:8px; padding:8px 24px;">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmDeleteUserBtn" style="background:#6c5ce7; border:none; border-radius:8px; padding:8px 32px;">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        $('#deleteUserModal').modal('show');
        $('#confirmDeleteUserBtn').off('click').on('click', function() {
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $('#deleteUserModal').modal('hide');
                    row.remove();
                    $('#successMessage').css('color','black').text('User deleted successfully!');
                    successModal.show();
                    setTimeout(function() { location.reload(); }, 1500);
                },
                error: function() {
                    $('#deleteUserModal').modal('hide');
                    $('#errorMessage').text('Failed to delete user. Please try again.');
                    errorModal.show();
                }
            });
        });
    });

});