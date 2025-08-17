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
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500; margin-bottom: 8px;">Resolution</label>
                                    <div class="custom-dropdown" style="position: relative;">
                                        <button class="custom-dropdown-btn w-100 d-flex justify-content-between align-items-center" type="button" id="resolutionDropdown" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 8px; padding: 12px 16px; text-align: left; cursor: pointer;">
                                            <span class="selected-resolution">1280 x 720</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <div class="custom-dropdown-menu" id="resolutionMenu" style="position: absolute; top: 100%; left: 0; right: 0; background: #2a2d3a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px; display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            <div class="custom-dropdown-item resolution-option" data-value="1280x720" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: visible;"></i>1280 x 720
                                            </div>
                                            <div class="custom-dropdown-item resolution-option" data-value="1920x1080" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>1920 x 1080
                                            </div>
                                            <div class="custom-dropdown-item resolution-option" data-value="1920x960" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>1920 x 960
                                            </div>
                                            <div class="custom-dropdown-item resolution-option" data-value="1920x1440" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>1920 x 1440
                                            </div>
                                            <div class="custom-dropdown-item resolution-option" data-value="1998x1080" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>1998 x 1080
                                            </div>
                                            <div class="custom-dropdown-item resolution-option" data-value="2048x858" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>2048 x 858
                                            </div>
                                        </div>
                                        <input type="hidden" name="resolution" value="1280x720">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500; margin-bottom: 8px;">Format</label>
                                    <div class="custom-dropdown" style="position: relative;">
                                        <button class="custom-dropdown-btn w-100 d-flex justify-content-between align-items-center" type="button" id="formatDropdown" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 8px; padding: 12px 16px; text-align: left; cursor: pointer;">
                                            <span class="selected-format">H264</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <div class="custom-dropdown-menu" id="formatMenu" style="position: absolute; top: 100%; left: 0; right: 0; background: #2a2d3a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px; display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            <div class="custom-dropdown-item format-option" data-value="H264" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: visible;"></i>H264
                                            </div>
                                            <div class="custom-dropdown-item format-option" data-value="ProResProxy" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>ProResProxy
                                            </div>
                                            <div class="custom-dropdown-item format-option" data-value="ProRes422Hq" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>ProRes422Hq
                                            </div>
                                            <div class="custom-dropdown-item format-option" data-value="ProRes422Lt" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>ProRes422Lt
                                            </div>
                                            <div class="custom-dropdown-item format-option" data-value="ProRes422Std" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>ProRes422Std
                                            </div>
                                            <div class="custom-dropdown-item format-option" data-value="ProRes4444" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>ProRes4444
                                            </div>
                                        </div>
                                        <input type="hidden" name="format" value="H264">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500; margin-bottom: 8px;">Frame Rate</label>
                                    <div class="custom-dropdown" style="position: relative;">
                                        <button class="custom-dropdown-btn w-100 d-flex justify-content-between align-items-center" type="button" id="frameRateDropdown" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 8px; padding: 12px 16px; text-align: left; cursor: pointer;">
                                            <span class="selected-framerate">23.976</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <div class="custom-dropdown-menu" id="frameRateMenu" style="position: absolute; top: 100%; left: 0; right: 0; background: #2a2d3a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px; display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            <div class="custom-dropdown-item framerate-option" data-value="23.976" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: visible;"></i>23.976
                                            </div>
                                            <div class="custom-dropdown-item framerate-option" data-value="24" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>24
                                            </div>
                                            <div class="custom-dropdown-item framerate-option" data-value="29.976" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>29.976
                                            </div>
                                            <div class="custom-dropdown-item framerate-option" data-value="30" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>30
                                            </div>
                                            <div class="custom-dropdown-item framerate-option" data-value="60" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>60
                                            </div>
                                        </div>
                                        <input type="hidden" name="frame_rate" value="23.976">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #e2e8f0; font-weight: 500; margin-bottom: 8px;">Speed <span style="color: #a0aec0; font-size: 0.85rem;">(px/frame)</span></label>
                                    <div class="custom-dropdown" style="position: relative;">
                                        <button class="custom-dropdown-btn w-100 d-flex justify-content-between align-items-center" type="button" id="speedDropdown" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 8px; padding: 12px 16px; text-align: left; cursor: pointer;">
                                            <span class="selected-speed">5</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <div class="custom-dropdown-menu" id="speedMenu" style="position: absolute; top: 100%; left: 0; right: 0; background: #2a2d3a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px; display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                                            <div class="custom-dropdown-item speed-option" data-value="1" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>1
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="2" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>2
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="3" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>3
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="4" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>4
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="5" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: visible;"></i>5
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="6" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>6
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="7" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>7
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="8" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>8
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="9" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>9
                                            </div>
                                            <div class="custom-dropdown-item speed-option" data-value="10" style="color: #fff; padding: 8px 12px; border-radius: 6px; display: flex; align-items: center; cursor: pointer;">
                                                <i class="bi bi-check text-success me-2" style="visibility: hidden;"></i>10
                                            </div>
                                        </div>
                                        <input type="hidden" name="speed" value="5">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" style="color: #e2e8f0; font-weight: 500; margin-bottom: 8px;">Running Time</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="text" name="running_time" id="runningTimeDisplay" class="form-control" value="01:53" readonly style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-family: 'JetBrains Mono', 'Courier New', monospace; font-weight: 500;">
                                    <div style="font-size: 0.85rem; color: #a0aec0;">
                                        Auto-calculated based on speed
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between mb-2" style="padding: 8px 0;">
                                    <span style="color: #a0aec0; font-size: 0.9rem;">
                                        <i class="bi bi-hourglass-split me-2"></i>You have 
                                        <span style="color: #48bb78; font-weight: 600;">0 / 3</span> 
                                        free renders left.
                                    </span>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="email_notification" id="emailNotification" checked style="border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.1);">
                                    <label class="form-check-label" for="emailNotification" style="color: #e2e8f0; font-size: 0.9rem;">
                                        <i class="bi bi-envelope me-2"></i>Email me when render is complete
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; font-weight: 600; padding: 14px; border-radius: 8px; font-size: 1.1rem; position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.6s;"></div>
                                    <i class="bi bi-play-circle-fill me-2" style="font-size: 1.2rem;"></i>Render
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
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff; font-weight: 600;">
                                <i class="bi bi-star me-2" style="color: #667eea;"></i>Your Subscription Plan
                            </h5>
                            <i class="bi bi-info-circle" style="color: #a0aec0; cursor: help;" title="Subscription details and limits"></i>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3" style="background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: -1px; left: -1px; right: -1px; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                                    <h6 style="color: #fff; margin-bottom: 8px; font-weight: 600;">Basic Plan</h6>
                                    <p style="color: #a0aec0; font-size: 0.9rem; margin-bottom: 12px; line-height: 1.5;">Limited scroll and card renders with watermark</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge d-flex align-items-center" style="background: rgba(72, 187, 120, 0.2); color: #48bb78; padding: 8px 12px; border-radius: 6px; font-weight: 600;">
                                            <i class="bi bi-check-circle-fill me-2"></i>Current
                                        </span>
                                        <button class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
                                            Upgrade
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3" style="background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                                    <h6 style="color: #fff; margin-bottom: 12px; font-weight: 600;">Your Plan Details</h6>
                                    <div class="d-flex align-items-center justify-content-between mb-2" style="padding: 6px 0;">
                                        <span style="color: #a0aec0; font-size: 0.9rem;">Renders Remaining:</span>
                                        <span style="color: #48bb78; font-weight: 600; font-size: 1.1rem;">3</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2" style="padding: 6px 0;">
                                        <span style="color: #a0aec0; font-size: 0.9rem;">Max Resolution:</span>
                                        <span style="color: #fff; font-weight: 600;">720p</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3" style="padding: 6px 0;">
                                        <span style="color: #a0aec0; font-size: 0.9rem;">Watermark:</span>
                                        <span style="color: #ed8936; font-weight: 600;">Yes</span>
                                    </div>
                                    <button class="btn btn-sm w-100" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 6px; font-weight: 500;">
                                        <i class="bi bi-info-circle me-2"></i>More Info
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
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Version</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Created</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Resolution</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Format</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">FPS</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Aspect Ratio</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Status</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Download</th>
                                            <th style="color: #a0aec0; font-weight: 500; padding: 1rem; font-size: 0.85rem;">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renders as $index => $render)
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                            <td style="color: #fff; padding: 1rem; font-weight: 500;">{{ $index + 1 }}</td>
                                            <td style="color: #a0aec0; padding: 1rem; font-size: 0.9rem;">{{ $render->created_at->format('D M j Y - H:i') }}</td>
                                            <td style="color: #fff; padding: 1rem; font-weight: 500;">{{ $render->resolution }}</td>
                                            <td style="color: #fff; padding: 1rem;">
                                                <span style="background: rgba(102, 126, 234, 0.15); color: #667eea; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 500;">
                                                    {{ $render->format }}
                                                </span>
                                            </td>
                                            <td style="color: #fff; padding: 1rem; font-weight: 500;">{{ $render->frame_rate }}</td>
                                            <td style="color: #a0aec0; padding: 1rem; font-size: 0.9rem;">
                                                @php
                                                    $resolution = explode('x', $render->resolution);
                                                    $aspectRatio = count($resolution) == 2 ? round($resolution[0] / $resolution[1], 2) : '1.78';
                                                @endphp
                                                {{ $aspectRatio }}
                                            </td>
                                            <td style="padding: 1rem;">
                                                @if($render->status === 'completed')
                                                    <span class="badge" style="background: rgba(72, 187, 120, 0.2); color: #48bb78; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                                        Completed
                                                    </span>
                                                @elseif($render->status === 'processing')
                                                    <span class="badge" style="background: rgba(66, 153, 225, 0.2); color: #4299e1; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                                        <i class="bi bi-hourglass-split me-1"></i>Processing
                                                    </span>
                                                @elseif($render->status === 'failed')
                                                    <span class="badge" style="background: rgba(245, 101, 101, 0.2); color: #f56565; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                                        Failed
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: rgba(237, 137, 54, 0.2); color: #ed8936; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRenderModal" tabindex="-1" aria-labelledby="deleteRenderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(24, 24, 40, 0.98); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1.5rem;">
                <h5 class="modal-title d-flex align-items-center" id="deleteRenderModalLabel" style="color: #fff; font-weight: 600;">
                    <i class="bi bi-exclamation-triangle-fill me-3" style="color: #f56565; font-size: 1.5rem;"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div class="d-flex align-items-start gap-3">
                    <div class="flex-shrink-0">
                        <div style="width: 48px; height: 48px; background: rgba(245, 101, 101, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-trash" style="color: #f56565; font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 style="color: #fff; margin-bottom: 8px; font-weight: 600;">Delete Render</h6>
                        <p style="color: #a0aec0; margin-bottom: 16px; line-height: 1.5;">
                            Are you sure you want to delete this render? This action cannot be undone and the render file will be permanently removed from the server.
                        </p>
                        <div class="p-3" style="background: rgba(245, 101, 101, 0.1); border-radius: 8px; border-left: 4px solid #f56565;">
                            <small style="color: #f56565; font-weight: 500;">
                                <i class="bi bi-info-circle me-2"></i>This will permanently delete the render file and cannot be recovered.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1); padding: 1.5rem; gap: 12px;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <button type="button" class="btn" id="confirmDeleteBtn" style="background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); border: none; color: white; border-radius: 8px; padding: 10px 20px; font-weight: 600;">
                    <i class="bi bi-trash me-2"></i>Delete Render
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 & Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, initializing custom dropdowns...');
        
        // Hide dashboard header
        const dashboardHeader = document.querySelector('.dashboard-header');
        if (dashboardHeader) {
            dashboardHeader.style.display = 'none';
        }
        
        // Initialize default values
        let currentSettings = {
            resolution: '1280x720',
            format: 'H264',
            frameRate: '23.976',
            speed: '5',
            videoLength: 1080
        };

        // Calculate running time based on speed and frame rate
        function calculateRunningTime() {
            const speed = parseFloat(currentSettings.speed);
            const frameRate = parseFloat(currentSettings.frameRate);
            const videoLength = currentSettings.videoLength;
            
            const totalFrames = videoLength / speed;
            const totalSeconds = totalFrames / frameRate;
            
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = Math.floor(totalSeconds % 60);
            
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        // Update running time display
        function updateRunningTime() {
            const runningTime = calculateRunningTime();
            const display = document.getElementById('runningTimeDisplay');
            if (display) {
                display.value = runningTime;
            }
        }

        // Custom dropdown functionality
        function initializeCustomDropdowns() {
            console.log('Initializing custom dropdowns...');
            
            // Close all dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-dropdown')) {
                    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });

            // Resolution dropdown
            const resolutionBtn = document.getElementById('resolutionDropdown');
            const resolutionMenu = document.getElementById('resolutionMenu');
            
            if (resolutionBtn && resolutionMenu) {
                console.log('Setting up resolution dropdown');
                
                resolutionBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    console.log('Resolution button clicked');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                        if (menu !== resolutionMenu) menu.style.display = 'none';
                    });
                    
                    // Toggle this dropdown
                    resolutionMenu.style.display = resolutionMenu.style.display === 'block' ? 'none' : 'block';
                });

                // Resolution option clicks
                resolutionMenu.querySelectorAll('.resolution-option').forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Resolution option clicked:', this.getAttribute('data-value'));
                        
                        const value = this.getAttribute('data-value');
                        const displayText = this.textContent.trim();
                        
                        // Update settings
                        currentSettings.resolution = value;
                        
                        // Update display
                        document.querySelector('.selected-resolution').textContent = displayText;
                        document.querySelector('input[name="resolution"]').value = value;
                        
                        // Update checkmarks
                        resolutionMenu.querySelectorAll('.bi-check').forEach(check => {
                            check.style.visibility = 'hidden';
                        });
                        this.querySelector('.bi-check').style.visibility = 'visible';
                        
                        // Close dropdown
                        resolutionMenu.style.display = 'none';
                    });
                });
            }

            // Format dropdown
            const formatBtn = document.getElementById('formatDropdown');
            const formatMenu = document.getElementById('formatMenu');
            
            if (formatBtn && formatMenu) {
                console.log('Setting up format dropdown');
                
                formatBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    console.log('Format button clicked');
                    
                    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                        if (menu !== formatMenu) menu.style.display = 'none';
                    });
                    
                    formatMenu.style.display = formatMenu.style.display === 'block' ? 'none' : 'block';
                });

                formatMenu.querySelectorAll('.format-option').forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Format option clicked:', this.getAttribute('data-value'));
                        
                        const value = this.getAttribute('data-value');
                        const displayText = this.textContent.trim();
                        
                        currentSettings.format = value;
                        
                        document.querySelector('.selected-format').textContent = displayText;
                        document.querySelector('input[name="format"]').value = value;
                        
                        formatMenu.querySelectorAll('.bi-check').forEach(check => {
                            check.style.visibility = 'hidden';
                        });
                        this.querySelector('.bi-check').style.visibility = 'visible';
                        
                        formatMenu.style.display = 'none';
                    });
                });
            }

            // Frame Rate dropdown
            const frameRateBtn = document.getElementById('frameRateDropdown');
            const frameRateMenu = document.getElementById('frameRateMenu');
            
            if (frameRateBtn && frameRateMenu) {
                console.log('Setting up frame rate dropdown');
                
                frameRateBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    console.log('Frame rate button clicked');
                    
                    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                        if (menu !== frameRateMenu) menu.style.display = 'none';
                    });
                    
                    frameRateMenu.style.display = frameRateMenu.style.display === 'block' ? 'none' : 'block';
                });

                frameRateMenu.querySelectorAll('.framerate-option').forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Frame rate option clicked:', this.getAttribute('data-value'));
                        
                        const value = this.getAttribute('data-value');
                        const displayText = this.textContent.trim();
                        
                        currentSettings.frameRate = value;
                        
                        document.querySelector('.selected-framerate').textContent = displayText;
                        document.querySelector('input[name="frame_rate"]').value = value;
                        
                        frameRateMenu.querySelectorAll('.bi-check').forEach(check => {
                            check.style.visibility = 'hidden';
                        });
                        this.querySelector('.bi-check').style.visibility = 'visible';
                        
                        frameRateMenu.style.display = 'none';
                        updateRunningTime();
                    });
                });
            }

            // Speed dropdown
            const speedBtn = document.getElementById('speedDropdown');
            const speedMenu = document.getElementById('speedMenu');
            
            if (speedBtn && speedMenu) {
                console.log('Setting up speed dropdown');
                
                speedBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    console.log('Speed button clicked');
                    
                    document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                        if (menu !== speedMenu) menu.style.display = 'none';
                    });
                    
                    speedMenu.style.display = speedMenu.style.display === 'block' ? 'none' : 'block';
                });

                speedMenu.querySelectorAll('.speed-option').forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Speed option clicked:', this.getAttribute('data-value'));
                        
                        const value = this.getAttribute('data-value');
                        const displayText = this.textContent.trim();
                        
                        currentSettings.speed = value;
                        
                        document.querySelector('.selected-speed').textContent = displayText;
                        document.querySelector('input[name="speed"]').value = value;
                        
                        speedMenu.querySelectorAll('.bi-check').forEach(check => {
                            check.style.visibility = 'hidden';
                        });
                        this.querySelector('.bi-check').style.visibility = 'visible';
                        
                        speedMenu.style.display = 'none';
                        updateRunningTime();
                    });
                });
            }
            
            console.log('Custom dropdowns initialized');
        }

        // Initialize everything
        updateRunningTime();
        initializeCustomDropdowns();

        // Handle render form submission
        const renderForm = document.getElementById('renderForm');
        if (renderForm) {
            renderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state with enhanced animation
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Starting Render...';
                submitBtn.disabled = true;
                submitBtn.style.background = 'linear-gradient(135deg, #4a5568 0%, #2d3748 100%)';
                
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
                    submitBtn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                });
            });
        }
        
        // Handle delete render buttons
        let renderToDelete = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteRenderModal'));
        
        document.querySelectorAll('.delete-render').forEach(button => {
            button.addEventListener('click', function() {
                renderToDelete = this.getAttribute('data-render-id');
                deleteModal.show();
            });
        });
        
        // Handle confirm delete button in modal
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (renderToDelete) {
                const deleteBtn = this;
                const originalText = deleteBtn.innerHTML;
                
                // Show loading state
                deleteBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Deleting...';
                deleteBtn.disabled = true;
                
                const deleteUrl = `{{ route("project.render.destroy", ["projectId" => $project->id, "renderId" => "RENDER_ID_PLACEHOLDER"]) }}`.replace('RENDER_ID_PLACEHOLDER', renderToDelete);
                
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
                        
                        // Find and animate row removal
                        const deleteButton = document.querySelector(`[data-render-id="${renderToDelete}"]`);
                        if (deleteButton) {
                            const row = deleteButton.closest('tr');
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-100%)';
                            setTimeout(() => {
                                row.remove();
                            }, 300);
                        }
                        
                        // Close modal
                        deleteModal.hide();
                    } else {
                        showNotification('Failed to delete render: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the render.', 'error');
                })
                .finally(() => {
                    // Restore button state
                    deleteBtn.innerHTML = originalText;
                    deleteBtn.disabled = false;
                    renderToDelete = null;
                });
            }
        });
    });

    // Enhanced utility function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            animation: slideInNotification 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        `;
        
        const iconClass = type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill';
        const bgColor = type === 'success' ? 'rgba(72, 187, 120, 0.1)' : type === 'error' ? 'rgba(245, 101, 101, 0.1)' : 'rgba(66, 153, 225, 0.1)';
        const textColor = type === 'success' ? '#48bb78' : type === 'error' ? '#f56565' : '#4299e1';
        
        notification.style.background = bgColor;
        notification.style.color = textColor;
        notification.style.border = `1px solid ${textColor}30`;
        
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="bi bi-${iconClass}" style="font-size: 1.2rem;"></i>
                <span style="font-weight: 500;">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: ${textColor}; font-size: 1.2rem; cursor: pointer; margin-left: auto; opacity: 0.7;">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideOutNotification 0.3s ease-in';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }, 5000);
    }
</script>

<style>
@keyframes slideInNotification {
    from { 
        transform: translateX(100%) scale(0.8); 
        opacity: 0; 
    }
    to { 
        transform: translateX(0) scale(1); 
        opacity: 1; 
    }
}

@keyframes slideOutNotification {
    from { 
        transform: translateX(0) scale(1); 
        opacity: 1; 
    }
    to { 
        transform: translateX(100%) scale(0.8); 
        opacity: 0; 
    }
}

/* Custom dropdown styling */
.custom-dropdown {
    position: relative;
}

.custom-dropdown-btn {
    transition: all 0.2s ease-in-out;
    border: none;
    outline: none;
}

.custom-dropdown-btn:hover {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(255,255,255,0.25) !important;
}

.custom-dropdown-btn:focus {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(102, 126, 234, 0.5) !important;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.custom-dropdown-menu {
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    animation: dropdownFadeIn 0.2s ease-out;
    border: 1px solid rgba(255,255,255,0.15) !important;
}

@keyframes dropdownFadeIn {
    from { 
        opacity: 0; 
        transform: translateY(-10px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.custom-dropdown-item {
    transition: all 0.15s ease-in-out;
    cursor: pointer;
}

.custom-dropdown-item:hover {
    background: rgba(255,255,255,0.1) !important;
    color: #fff !important;
}

.custom-dropdown-item:active {
    background: rgba(102, 126, 234, 0.2) !important;
    color: #fff !important;
}

/* Old dropdown styling - keeping for compatibility */
.dropdown-toggle {
    transition: all 0.2s ease-in-out;
}

.dropdown-toggle:hover {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(255,255,255,0.25) !important;
}

.dropdown-toggle:focus {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(102, 126, 234, 0.5) !important;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.dropdown-toggle::after {
    display: none; /* Hide default Bootstrap arrow since we have custom one */
}

.dropdown-menu {
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    animation: dropdownFadeIn 0.2s ease-out;
    border: 1px solid rgba(255,255,255,0.15) !important;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    transition: all 0.15s ease-in-out;
    cursor: pointer;
}

.dropdown-item:hover {
    background: rgba(255,255,255,0.1) !important;
    color: #fff !important;
}

.dropdown-item:active {
    background: rgba(102, 126, 234, 0.2) !important;
    color: #fff !important;
}

.dropdown-item:focus {
    background: rgba(255,255,255,0.1) !important;
    color: #fff !important;
}

/* Form controls */
.form-control:focus {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(102, 126, 234, 0.5) !important;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
    color: #fff !important;
}

.form-control[readonly] {
    background: rgba(255,255,255,0.05) !important;
    border-color: rgba(255,255,255,0.1) !important;
}

/* Button enhancements */
.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.btn:hover div {
    left: 100%;
}

.btn:active {
    transform: translateY(0);
}

/* Table enhancements */
.table-dark th, .table-dark td {
    border-color: rgba(255,255,255,0.05);
    transition: all 0.2s ease-in-out;
}

.table-hover tbody tr:hover {
    background-color: rgba(255,255,255,0.05) !important;
}

/* Card hover effects */
.card {
    transition: all 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

/* Enhance badges */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Custom scrollbar for dropdowns */
.dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.dropdown-menu::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 3px;
}

.dropdown-menu::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 3px;
}

.dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

/* Loading animation for render button */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.btn:disabled .bi-hourglass-split {
    animation: spin 1s linear infinite;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 8px;
    }
    
    .card {
        margin-bottom: 1rem;
    }
    
    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }
}

/* Enhanced form labels */
.form-label {
    display: flex;
    align-items: center;
    gap: 6px;
}

.form-label::before {
    content: '';
    width: 3px;
    height: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

/* Status indicator animations */
.badge {
    position: relative;
    overflow: hidden;
}

.badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.badge:hover::before {
    left: 100%;
}

/* Modal enhancements */
.modal-content {
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5) !important;
}

.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.8) !important;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.8;
    transition: all 0.2s ease-in-out;
}

.btn-close-white:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Loading animation for delete button */
.btn:disabled .bi-hourglass-split {
    animation: spin 1s linear infinite;
}

/* Modal animation */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}
</style>

@endsection
