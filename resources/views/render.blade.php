@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-body" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #fff; min-height: 100vh; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
    <div class="container-fluid">
        <div class="row">
            <!-- Header with project name -->
            <div class="col-12 mb-4 pt-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1" style="color: #fff; font-weight: 600;">{{ $project->template_name }}</h4>
                        <p class="mb-0" style="color: #a0aec0; font-size: 0.9rem;">Render Settings & Export</p>
                    </div>
                    <a href="{{ route('dashboard.credit', ['id' => $project->id]) }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to Editor
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Render Settings Panel -->
            <div class="col-md-6">
                <div class="card" style="background: rgba(24, 24, 40, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1.5rem;">
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                            <i class="bi bi-gear me-2"></i>Select Render Settings
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <form id="renderForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500;">Resolution</label>
                                    <select name="resolution" class="form-select" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="1280x720" style="background: #2d3748; color: #fff;">1280 x 720</option>
                                        <option value="1920x1080" style="background: #2d3748; color: #fff;">1920 x 1080</option>
                                        <option value="3840x2160" style="background: #2d3748; color: #fff;">3840 x 2160</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500;">Format</label>
                                    <select name="format" class="form-select" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="H264" style="background: #2d3748; color: #fff;">H264</option>
                                        <option value="H265" style="background: #2d3748; color: #fff;">H265</option>
                                        <option value="MOV" style="background: #2d3748; color: #fff;">MOV</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500;">Frame Rate</label>
                                    <select name="frame_rate" class="form-select" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="23.976" style="background: #2d3748; color: #fff;">23.976</option>
                                        <option value="24" style="background: #2d3748; color: #fff;">24</option>
                                        <option value="25" style="background: #2d3748; color: #fff;">25</option>
                                        <option value="29.97" style="background: #2d3748; color: #fff;">29.97</option>
                                        <option value="30" style="background: #2d3748; color: #fff;">30</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500;">Speed (px/frame)</label>
                                    <select name="speed" class="form-select" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="1" style="background: #2d3748; color: #fff;">1</option>
                                        <option value="2" style="background: #2d3748; color: #fff;">2</option>
                                        <option value="3" style="background: #2d3748; color: #fff;">3</option>
                                        <option value="4" style="background: #2d3748; color: #fff;">4</option>
                                        <option value="5" selected style="background: #2d3748; color: #fff;">5</option>
                                        <option value="6" style="background: #2d3748; color: #fff;">6</option>
                                        <option value="7" style="background: #2d3748; color: #fff;">7</option>
                                        <option value="8" style="background: #2d3748; color: #fff;">8</option>
                                        <option value="9" style="background: #2d3748; color: #fff;">9</option>
                                        <option value="10" style="background: #2d3748; color: #fff;">10</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" style="color: #e2e8f0; font-weight: 500;">Running Time</label>
                                <input type="text" name="running_time" class="form-control" value="01:53" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                            </div>

                            <div class="mt-3">
                                <p style="color: #a0aec0; font-size: 0.9rem; margin-bottom: 0.5rem;">
                                    You have <span style="color: #48bb78; font-weight: 600;">0 / 3</span> free renders left.
                                </p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="email_notification" id="emailNotification" checked style="border-color: rgba(255,255,255,0.3);">
                                    <label class="form-check-label" for="emailNotification" style="color: #e2e8f0;">
                                        Email me when render is complete
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; font-weight: 600; padding: 12px; border-radius: 8px; font-size: 1.1rem;">
                                    <i class="bi bi-play-circle me-2"></i>Render
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Subscription & Render History -->
            <div class="col-md-6">
                <!-- Subscription Plan -->
                <div class="card mb-4" style="background: rgba(24, 24, 40, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1.5rem;">
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                            <i class="bi bi-info-circle me-2"></i>Your Subscription Plan
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3" style="background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                                    <h6 style="color: #fff; margin-bottom: 8px;">Basic Plan</h6>
                                    <p style="color: #a0aec0; font-size: 0.9rem; margin-bottom: 12px;">Limited scroll and card renders with watermark</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge" style="background: rgba(72, 187, 120, 0.2); color: #48bb78; padding: 6px 12px; border-radius: 6px;">
                                            <i class="bi bi-check-circle me-1"></i>Current
                                        </span>
                                        <button class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 6px 16px; border-radius: 6px;">
                                            Upgrade
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3" style="background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                                    <h6 style="color: #fff; margin-bottom: 8px;">Your Plan Details</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span style="color: #a0aec0; font-size: 0.9rem;">Renders Remaining:</span>
                                        <span style="color: #fff; font-weight: 600;">3</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span style="color: #a0aec0; font-size: 0.9rem;">Resolution:</span>
                                        <span style="color: #fff; font-weight: 600;">720p</span>
                                    </div>
                                    <button class="btn btn-sm w-100 mt-2" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 6px;">
                                        More Info
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Render History -->
                <div class="card" style="background: rgba(24, 24, 40, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1.5rem;">
                        <h5 class="mb-0" style="color: #fff; font-weight: 600;">Render History</h5>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        @if($renders && $renders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0">
                                    <thead style="background: rgba(255,255,255,0.05);">
                                        <tr>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Version</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Created</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Resolution</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Format</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">FPS</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Status</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Download</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem;">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renders as $index => $render)
                                        <tr>
                                            <td style="color: #fff; padding: 1rem;">{{ $index + 1 }}</td>
                                            <td style="color: #fff; padding: 1rem;">{{ $render->created_at->format('D M j Y - H:i') }}</td>
                                            <td style="color: #fff; padding: 1rem;">{{ $render->resolution }}</td>
                                            <td style="color: #fff; padding: 1rem;">{{ $render->format }}</td>
                                            <td style="color: #fff; padding: 1rem;">{{ $render->frame_rate }}</td>
                                            <td style="padding: 1rem;">
                                                @if($render->status === 'completed')
                                                    <span class="badge" style="background: rgba(72, 187, 120, 0.2); color: #48bb78; padding: 6px 12px; border-radius: 6px;">
                                                        Completed
                                                    </span>
                                                @elseif($render->status === 'processing')
                                                    <span class="badge" style="background: rgba(66, 153, 225, 0.2); color: #4299e1; padding: 6px 12px; border-radius: 6px;">
                                                        <i class="bi bi-hourglass-split me-1"></i>In-progress
                                                    </span>
                                                @elseif($render->status === 'failed')
                                                    <span class="badge" style="background: rgba(245, 101, 101, 0.2); color: #f56565; padding: 6px 12px; border-radius: 6px;">
                                                        Failed
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: rgba(237, 137, 54, 0.2); color: #ed8936; padding: 6px 12px; border-radius: 6px;">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="padding: 1rem;">
                                                @if($render->status === 'completed')
                                                    <a href="{{ route('project.render.download', ['projectId' => $project->id, 'renderId' => $render->id]) }}" class="btn btn-sm" style="background: rgba(72, 187, 120, 0.2); border: 1px solid rgba(72, 187, 120, 0.3); color: #48bb78; border-radius: 6px;">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm" disabled style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #a0aec0; border-radius: 6px;">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td style="padding: 1rem;">
                                                <button class="btn btn-sm delete-render" data-render-id="{{ $render->id }}" style="background: rgba(245, 101, 101, 0.2); border: 1px solid rgba(245, 101, 101, 0.3); color: #f56565; border-radius: 6px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-film" style="font-size: 3rem; color: #a0aec0; margin-bottom: 1rem;"></i>
                                <p style="color: #a0aec0; margin-bottom: 0;">No renders yet. Start your first render above!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 & Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $('.dashboard-header').css('display', 'none');
    })

    document.addEventListener('DOMContentLoaded', function() {
        // Handle render form submission
        document.getElementById('renderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Starting Render...';
            submitBtn.disabled = true;
            
            fetch('{{ route("project.render.store", ["projectId" => $project->id]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Render started successfully! Refresh the page to see it in the history.', 'success');
                    
                    // Refresh the page after 2 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showNotification('Failed to start render: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while starting the render.', 'error');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
        
        // Handle delete render buttons
        document.querySelectorAll('.delete-render').forEach(button => {
            button.addEventListener('click', function() {
                const renderId = this.getAttribute('data-render-id');
                
                if (confirm('Are you sure you want to delete this render?')) {
                    const deleteUrl = `{{ route("project.render.destroy", ["projectId" => $project->id, "renderId" => "RENDER_ID_PLACEHOLDER"]) }}`.replace('RENDER_ID_PLACEHOLDER', renderId);
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Render deleted successfully!', 'success');
                            // Remove the row from the table
                            this.closest('tr').remove();
                        } else {
                            showNotification('Failed to delete render.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while deleting the render.', 'error');
                    });
                }
            });
        });
    });

    // Utility function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
        `;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 4 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 4000);
    }
</script>

<style>
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.form-select option {
    background: #2d3748 !important;
    color: #fff !important;
}

.table-dark th, .table-dark td {
    border-color: rgba(255,255,255,0.1);
}

.table-hover tbody tr:hover {
    background-color: rgba(255,255,255,0.05);
}
</style>

@endsection
