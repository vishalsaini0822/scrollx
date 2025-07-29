@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="slider-wrapper">
            <h2>CHOOSE YOUR NEW PROJECT</h2>
            <div class="project-slider">
                @foreach ($template as $key => $item)
                    @if($key == 0)
                        <div class="slide" onclick="selectTemplate({{ $item->id }});">
                            <span class="project-title title-active">{{ !empty($item->template_name)?$item->template_name:'' }}</span>
                        </div>
                    @else
                        <div class="slide" onclick="selectTemplate({{ $item->id }});">
                            <span class="project-title">{{ !empty($item->template_name)?$item->template_name:'' }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div style="margin-top: 40px;">
            <h2 style="margin-left: 10px; font-weight: 700;">My Projects</h2>
            <div class="project-table" style="overflow-x:auto;">
                <table style="width:100%; border-collapse: separate; border-spacing: 0 18px; background: none;">
                    <thead>
                        <tr style="background: none;">
                            <th style="color:#fff; font-size:24px; font-weight:700; border:none; background:none; padding-bottom:18px;">Project Name</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Type</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Status</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Created <span style="font-size: 14px; vertical-align: middle;">&#8597;</span></th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Options</th>
                            <th style="color:#fff; font-size:18px; font-weight:600; border:none; background:none;">Edit Project</th>
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
                        <tr data-project-id="{{ $project->id }}" style="background: #23232b; border-radius: 16px; box-shadow: 0 2px 12px #0002;">
                            <td style="font-size:20px; font-weight:700; border:none; background:none; padding: 18px 24px;">
                                {{ !empty($project->template_name)?ucfirst($project->template_name):'' }}</td>
                            <td style="font-size:16px; border:none; background:none;">
                                @if(!empty($project->end_credits_type) && $project->end_credits_type == 'static_cards' )
                                Card @else Scrolling @endif
                            </td>
                            <td style="border:none; background:none;">
                                <select class="form-control status-dropdown"
                                    style="background: #18181f; color: #fff; border: 1px solid #444; width: 115px;">
                                    <option value="no_status" {{ $project->status == 'no_status' ? 'selected' : '' }}>No Status</option>
                                    <option value="approved" {{ $project->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="need_review" {{ $project->status == 'need_review' ? 'selected' : '' }}>Need Review</option>
                                </select>
                            </td>
                            <td style="border:none; background:none; font-size:16px;">
                                {{ \Carbon\Carbon::parse($project->created_at)->format('D M d Y - H:i:s') }}
                            </td>
                            <td class="options" style="white-space:nowrap; border:none; background:none;">
                                <i class="fa fa-pencil-square-o edit-project" aria-hidden="true" title="Edit" style="margin-right:10px; cursor:pointer; color:#fff;"></i>
                                <i class="fa fa-clone copy-project" title="Copy" aria-hidden="true" style="margin-right:10px; cursor:pointer; color:#fff;"></i>

                                <i class="fa fa-file-text-o render-project" title="Render" style="margin-right:10px; cursor:pointer; color:#fff;" aria-hidden="true"></i>

                                <i class="fa fa-trash-o delete-project" title="Delete" style="cursor:pointer; color:#fff;" aria-hidden="true"></i>

                            </td>
                            <td style="border:none; background:none;">
                                <a href="{{ route('dashboard.credit', ['id' => $project->id]) }}" class="btn btn-primary btn-xs d-flex justify-content-center align-items-center"
                                    style="background: #6c5ce7; border: none; border-radius: 20px; padding: 10px 22px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-chevron-right" style="font-size: 20px; margin: 0 auto;"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade mymodal" id="save_template" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createProjectForm"  autocomplete="off">
                    @csrf
                    <input type="hidden" name="project_id" id="form-project-id" value="">
                    <input type="hidden" name="template_id" id="form-template-id" value="">
                    <div class="modal-header" style="border-bottom: none;">
                        <div class="modal-top">
                            <h4 class="modal-title select_template_hearder " id="modal-title-id">Create Scroll Project</h4>
                            <span>Project names can be changed anytime.</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="template_name" class="select_template_hearder" style="color: #fff;">Project
                                Name</label>
                            <input type="text" name="template_name" id="template_name" class="form-control"
                                placeholder="Enter Project Name"
                                style="background: #18181f; color: #fff; border: 1px solid #444;" />
                            <span class="help-block" id="nameError" style="color:#ff7675; display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="end_credits_type">What
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
                                style="display: inline-block; background: #18181f; color: #fff; border: 1px solid #444;">
                                <option value="">Select a resolution</option>
                                <option value="1280x720">1280 x 720</option>
                                <option value="1920x1080">1920 x 1080</option>
                                <option value="1920x960">1920 x 960</option>
                                <option value="1920x1440">1920 x 1440</option>
                                <option value="1998x1080">1998 x 1080</option>
                            </select>
                            <span class="help-block" id="resolutionError" style="color:#ff7675; display:none;"></span>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                            style="background: none; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 8px 24px;">Cancel</button>
                        <button type="submit" class="btn btn-primary"
                            style="background: #6c5ce7; border: none; border-radius: 8px; padding: 8px 32px;">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection