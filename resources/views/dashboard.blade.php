<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ScrollX.io Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #1e1f26;
        color: #fff;
    }

    header {
        background: #2c2e3a;
        padding: 20px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    .slider-wrapper {
        padding: 20px;
    }

    .slick-slide {
        margin: 0 10px;
    }

    .slide {
        background: #000;
        border-radius: 10px;
        height: 160px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }

    .project-title {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        opacity: 0;
        transition: all .5s ease;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .project-slider .slide:hover span,
    .project-slider .slide:hover span:before {
        opacity: 1;
    }

    .title-active {
        opacity: 1;
    }

    .project-slider .slide span:before {
        background: linear-gradient(90deg, #212226, #ead2b04a);
        position: absolute;
        content: "";
        width: 100%;
        height: 100%;
        opacity: 0
    }

    /* .project-table table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background: #2c2e3a;
    } */

    /* .project-table th,
    .project-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    .project-table th {
        background: #3a3d4a;
    }

    .project-table .status-approved {
        color: #0f0;
        background: #202b20;
        padding: 5px 10px;
        border-radius: 4px;
    } */

    /* .project-table .status-no-status {
        color: #f00;
        background: #2b2020;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .project-table .options i {
        margin-right: 10px;
        cursor: pointer;
    } */
    .select_template_hearder {
        color: black;
    }
    </style>
</head>

<body>
    <header>DASHBOARD</header>

    <div class="container">
        <div class="slider-wrapper">
            <h2>CHOOSE YOUR NEW PROJECT</h2>
            <div class="project-slider">
                <div class="slide" onclick=selectTemplate(1);><span
                        class="project-title title-active">CustomProject</span></div>
                <div class="slide" onclick=selectTemplate(2);>
                    <span class="project-title">Vintage</span>
                </div>
                <div class="slide" onclick=selectTemplate(3);>
                    <span class="project-title">Elegant</span>
                </div>
                <div class="slide" onclick=selectTemplate(4);>
                    <span class="project-title">Retro</span>
                </div>
                <div class="slide" onclick=selectTemplate(5);>
                    <span class="project-title">Minimal</span>
                </div>
                <div class="slide" onclick=selectTemplate(6);>
                    <span class="project-title">Velvet</span>
                </div>
                <div class="slide" onclick=selectTemplate(7);>
                    <span class="project-title">Urban</span>
                </div>
                <div class="slide" onclick=selectTemplate(8);>
                    <span class="project-title">Classic</span>
                </div>
                <div class="slide" onclick=selectTemplate(9);>
                    <span class="project-title">Sci Fi</span>
                </div>
                <div class="slide" onclick=selectTemplate(10);>
                    <span class="project-title">Bold</span>
                </div>
                <div class="slide" onclick=selectTemplate(11);>
                    <span class="project-title">Timeless</span>
                </div>
                <div class="slide" onclick=selectTemplate(12);>
                    <span class="project-title">Modern</span>
                </div>
                <div class="slide" onclick=selectTemplate(13);>
                    <span class="project-title">Dramatic</span>
                </div>
                <div class="slide" onclick=selectTemplate(14);>
                    <span class="project-title">Ancient</span>
                </div>
                <div class="slide" onclick=selectTemplate(15);>
                    <span class="project-title">Nostalgic</span>
                </div>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <h2 style="margin-left: 10px; font-weight: 700;">My Projects</h2>
            <div class="project-table" style="overflow-x:auto;">
                <table style="width:100%; border-collapse: separate; border-spacing: 0 18px; background: none;">
                    <thead>
                        <tr style="background: none;">
                            <th
                                style="color:#fff; font-size:24px; font-weight:700; border:none; background:none; padding-bottom:18px;">
                                Project Name</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Type
                            </th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">
                                Status</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">
                                Created <span style="font-size: 14px; vertical-align: middle;">&#8597;</span>
                            </th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">
                                Options</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Edit
                                Project</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($projects->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #fff;">
                                <strong>Create Project to Get Started.</strong>
                            </td>
                        </tr>
                        @endif
                        @foreach($projects as $project)
                        <tr data-project-id="{{ $project->id }}"
                            style="background: #23232b; border-radius: 16px; box-shadow: 0 2px 12px #0002;">
                            <td
                                style="font-size:20px; font-weight:700; border:none; background:none; padding: 18px 24px;">
                                {{ !empty($project->template_name)?ucfirst($project->template_name):'' }}</td>
                            <td style="font-size:16px; border:none; background:none;">
                                @if(!empty($project->end_credits_type) && $project->end_credits_type == 'static_cards' )
                                Card @else Scrolling @endif </td>
                            <td style="border:none; background:none;">
                                <select class="form-control status-dropdown"
                                    style="background: #18181f; color: #fff; border: 1px solid #444; width: 115px;">
                                    <option value="no_status" {{ $project->status == 'no_status' ? 'selected' : '' }}>No
                                        Status</option>
                                    <option value="approved" {{ $project->status == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="in_progress"
                                        {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="need_review"
                                        {{ $project->status == 'need_review' ? 'selected' : '' }}>Need Review</option>
                                </select>
                            </td>
                            <td style="border:none; background:none; font-size:16px;">
                                {{ \Carbon\Carbon::parse($project->created_at)->format('D M d Y - H:i:s') }}
                            </td>
                            <td class="options" style="white-space:nowrap; border:none; background:none;">
                                <i class="glyphicon glyphicon-pencil edit-project" title="Edit"
                                    style="margin-right:10px; cursor:pointer; color:#fff;"></i>
                                <i class="glyphicon glyphicon-duplicate copy-project" title="Copy"
                                    style="margin-right:10px; cursor:pointer; color:#fff;"></i>
                                <i class="glyphicon glyphicon-play-circle render-project" title="Render"
                                    style="margin-right:10px; cursor:pointer; color:#fff;"></i>
                                <i class="glyphicon glyphicon-trash delete-project" title="Delete"
                                    style="cursor:pointer; color:#fff;"></i>
                            </td>
                            <td style="border:none; background:none;">
                                <button class="btn btn-primary btn-xs edit-project-btn"
                                    style="background: #6c5ce7; border: none; border-radius: 20px; padding: 10px 22px;">
                                    <span class="glyphicon glyphicon-chevron-right" style="font-size: 20px;"></span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        $(document).ready(function() {
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
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Optionally show a toast or update UI
                        // Update the status text in the dropdown (if needed)
                        // Optionally highlight the row to indicate update
                        row.find('.status-dropdown').val(newStatus);
                        row.css('background', '#2d3a2d');
                        setTimeout(function() {
                            row.css('background', '#23232b');
                        }, 800);
                    },
                    error: function() {
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
                });
            });

            // Edit
            $('.edit-project, .edit-project-btn').click(function() {
                var row = $(this).closest('tr');
                var projectId = row.data('project-id');
                // Fetch project data via AJAX and show in modal
                $.ajax({
                    url: '/projects/' + projectId + '/edit',
                    method: 'GET',
                    success: function(response) {
                        // Assuming response contains HTML for the modal body
                        // Or you can fill the form fields manually if response is JSON
                        $('#save_template .modal-title').text('Rename Scroll Project');
                        $('#template_name').val(response.template_name || '');
                        $('#end_credits_type').val(response.end_credits_type || 'scrolling');
                        if (response.end_credits_type === 'static_cards') {
                            selectEndCreditType('static_cards');
                            $('#resolution').val(response.resolution || '');
                        } else {
                            selectEndCreditType('scrolling');
                        }
                        // Change submit button text
                        $('#createProjectForm button[type="submit"]').text('Update');
                        // Store project id in form for update
                        $('#form-project-id').val(projectId);
                        $('#save_template').modal('show');
                    },
                    error: function() {
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

                // Reset errors
                $('#nameError').hide();
                $('#resolutionError').hide();

                // Validate project name
                if (name.length < 3) {
                    $('#nameError').text('Project name must be at least 3 characters.').show();
                    valid = false;
                }

                // Validate resolution if static_cards
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
                    _token: '{{ csrf_token() }}'
                };

                // If editing, change URL and method
                if (projectId) {
                    url = '/projects/' + projectId;
                    method = 'PUT';
                    data.project_id = projectId;
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        $('#save_template').modal('hide');
                        // Show success modal/message
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

                // Show modal
                $('#duplicateProjectModal').modal('show');

                // Handle confirm
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
                            _token: '{{ csrf_token() }}',
                            template_name: newName
                        },
                        success: function() {
                            $('#duplicateProjectModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            $('#duplicateProjectModal').modal('hide');
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
                // Show custom confirmation modal
                var row = $(this).closest('tr');
                var projectId = row.data('project-id');
                var projectName = row.find('td:first').text().trim();

                // Remove existing modal if present
                $('#deleteConfirmModal').remove();

                // Append modal HTML to body
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

                // Show modal
                $('#deleteConfirmModal').modal('show');

                // Handle confirm
                $('#confirmDeleteBtn').off('click').on('click', function() {
                    $.ajax({
                        url: '/projects/' + projectId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $('#deleteConfirmModal').modal('hide');
                            row.remove();
                            // Show success modal/message
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
                        },
                        error: function() {
                            $('#deleteConfirmModal').modal('hide');
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
                    });
                });
            });
        });
        </script>
    </div>


    <div class="modal fade" id="save_template" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background: #23232b; color: #fff; border-radius: 16px;">
                <form id="createProjectForm"  autocomplete="off">
                    <input type="hidden" name="project_id" id="form-project-id" value="">
                    <input type="hidden" name="template_id" id="form-template-id" value="">
                    <div class="modal-header" style="border-bottom: none;">
                        <button type="button" class="close" data-dismiss="modal"
                            style="color: #fff; opacity: 1;">&times;</button>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div
                                style="background: #23232b; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border: 2px solid #444;">
                                <span style="font-size: 24px; color: #fff;">🗂️</span>
                            </div>
                            <div>
                                <h4 class="modal-title select_template_hearder " id="modal-title-id"
                                    style="margin: 0; color: #fff; font-size: 28px; font-weight: 700;">Create Scroll Project</h4>
                                <div style="color: #bbaaff; font-size: 14px;">Project names can be changed anytime.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" style="padding-top: 18px;">
                        <div class="form-group">
                            <label for="template_name" class="select_template_hearder" style="color: #fff;">Project
                                Name</label>
                            <input type="text" name="template_name" id="template_name" class="form-control"
                                placeholder="Enter Project Name"
                                style="background: #18181f; color: #fff; border: 1px solid #444;" />
                            <span class="help-block" id="nameError" style="color:#ff7675; display:none;"></span>
                        </div>
                        <div class="form-group" style="margin-bottom: 25px;">
                            <label for="end_credits_type" style="margin-bottom: 10px; display: block; color: #fff;">What
                                type of End Credits?</label>
                            <div
                                style="display: flex; align-items: center; background: #18181f; border-radius: 12px; border: 1px solid #444; width: fit-content;">
                                <button type="button" class="btn" id="scrollingBtn"
                                    style="background: none; border: none; color: #fff; font-size: 20px; font-weight: 600; padding: 16px 38px; border-radius: 12px 0 0 12px; transition: color .2s;"
                                    onclick="selectEndCreditType('scrolling')">Scrolling</button>
                                <span style="width:1px; height:40px; background:#444; display:inline-block;"></span>
                                <button type="button" class="btn" id="staticCardsBtn"
                                    style="background: none; border: none; color: #bbaaff; font-size: 20px; font-weight: 600; padding: 16px 38px; border-radius: 0 12px 12px 0; transition: color .2s;"
                                    onclick="selectEndCreditType('static_cards')">Static Cards</button>
                            </div>
                            <input type="hidden" name="end_credits_type" id="end_credits_type" value="scrolling">
                        </div>
                        <div class="form-group" id="resolution-group" style="margin-bottom: 10px; display: none;">
                            <label for="resolution" style="margin-bottom: 10px; display: block; color: #fff;">Choose
                                Resolution</label>
                            <select class="form-control" id="resolution" name="resolution"
                                style="width: 220px; display: inline-block; background: #18181f; color: #fff; border: 1px solid #444;">
                                <option value="">Select a resolution</option>
                                <option value="1280x720">1280 x 720</option>
                                <option value="1920x1080">1920 x 1080</option>
                                <option value="1920x960">1920 x 960</option>
                                <option value="1920x1440">1920 x 1440</option>
                                <option value="1998x1080">1998 x 1080</option>
                            </select>
                            <span class="help-block" id="resolutionError" style="color:#ff7675; display:none;"></span>
                        </div>
                        <script>
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
                        // Set default
                        $(function() {
                            selectEndCreditType('scrolling');
                        });
                        </script>
                    </div>
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="background: none; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 8px 24px;">Cancel</button>
                        <button type="submit" class="btn btn-primary"
                            style="background: #6c5ce7; border: none; border-radius: 8px; padding: 8px 32px;">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        $('.project-slider').slick({
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true
        });
    });

    function selectTemplate(value) {
        $('#form-template-id').val(value);
        $('#save_template').modal('show');
    }
    </script>
</body>

</html>