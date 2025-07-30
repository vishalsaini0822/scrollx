@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="dashboard-body" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #fff; height: 100vh; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;">
        <div class="container-fluid h-100">
            <div class="row h-100" style="height: 100%;">
                <!-- Sidebar: Credit Block Menu -->
                <div class="col-2 sidebar p-0 d-flex flex-column" id="sidebarHeadings"
                    style="background: rgba(24, 24, 40, 0.95); backdrop-filter: blur(10px); color: #fff; border-right: 1px solid rgba(255,255,255,0.1); min-height: 100vh; height: 100%;">
                    <div class="p-3 fw-bold" style="color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 1.1rem; display: flex; align-items: center; justify-content: space-between;">
                        <span>Credit Blocks</span>
                        <i class="bi bi-info-circle ms-1" style="opacity:0.7;"></i>
                    </div>
                    <div id="sheetHeadings" class="flex-grow-1" style="overflow-y: auto; padding: 0.5rem;"></div>
                </div>

                <!-- Main Content: Credit Block Content -->
                <div class="col-7 main-content d-flex flex-column position-relative"
                    id="mainContent"
                    style="background: rgba(16, 16, 20, 0.8); backdrop-filter: blur(10px); color: #fff; border-right: 1px solid rgba(255,255,255,0.1); position: relative; scrollbar-width: none; flex-grow: 1 !important; min-height: 0 !important; overflow-y: auto !important; scroll-behavior: smooth;">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
                        #mainContent::-webkit-scrollbar { display: none; }
                        #mainContent { -ms-overflow-style: none; scrollbar-width: none; }
                        .btn-custom { 
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                            border: none; 
                            color: white; 
                            border-radius: 8px;
                            font-weight: 500;
                            transition: all 0.3s ease;
                        }
                        .btn-custom:hover { 
                            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%); 
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
                        }
                        .modern-card {
                            background: rgba(255, 255, 255, 0.05);
                            backdrop-filter: blur(10px);
                            border-radius: 12px;
                            border: 1px solid rgba(255, 255, 255, 0.1);
                            transition: all 0.3s ease;
                        }
                        .modern-card:hover {
                            background: rgba(255, 255, 255, 0.08);
                            border-color: rgba(255, 255, 255, 0.2);
                        }
                        .credit-block-btn {
                            background: rgba(255, 255, 255, 0.05);
                            border: 1px solid rgba(255, 255, 255, 0.1);
                            border-radius: 8px;
                            margin-bottom: 0.25rem;
                            transition: all 0.3s ease;
                        }
                        .credit-block-btn:hover {
                            background: rgba(255, 255, 255, 0.1);
                            border-color: rgba(102, 126, 234, 0.5);
                            transform: translateX(4px);
                        }
                        .credit-block-btn.active {
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-color: #667eea;
                            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                        }
                    </style>
                    <div class="w-100" id="sheetContent" style="max-width: 700px; padding-bottom: 4rem; margin: 0 auto; padding: 2rem 0;"></div>
                </div>

                <!-- Content Adjustment Tools -->
                <div class="col-3 content-adjustment d-flex flex-column modern-card"
                    style="background: rgba(24, 24, 40, 0.95); backdrop-filter: blur(10px); color: #fff; min-height: 100vh; height: 100%; border-left: 1px solid rgba(255,255,255,0.1); overflow-y: auto; padding: 2rem 1.5rem; margin: 0;">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-group modern-card" role="group" style="width:100%; border-radius: 8px; overflow: hidden;">
                            <button class="btn btn-sm btn-outline-light active" id="layoutTab" style="opacity:1; width:50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">Layout</button>
                            <button class="btn btn-sm btn-outline-light" id="fontTab" style="opacity:0.7; width:50%; background: rgba(255,255,255,0.1); border: none;">Font</button>
                        </div>
                    </div>
                    <div id="layoutPanel">
                        <div class="mb-3">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Block type</label>
                            <select class="form-select form-select-sm modern-card" id="blockType" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                <option style="background: #2d3748; color: #fff;">Role + Name</option>
                                <option style="background: #2d3748; color: #fff;">Name Only</option>
                                <option style="background: #2d3748; color: #fff;">Logo</option>
                                <option style="background: #2d3748; color: #fff;">Blurb</option>
                                <option style="background: #2d3748; color: #fff;">Song</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="heading" class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Heading</label>
                            <input type="text" class="form-control form-control-sm modern-card" id="heading" placeholder="Enter text here" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                        </div>
                        <div class="mb-2">
                            <label for="subHeading" class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Sub-Heading</label>
                            <input type="text" class="form-control form-control-sm modern-card" id="subHeading" placeholder="Enter text here" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Alignment</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-light btn-sm align-btn modern-card" data-align="left" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-align-start"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm align-btn modern-card" data-align="center" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-align-center"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm align-btn modern-card" data-align="right" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-align-end"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm align-btn active modern-card" data-align="double" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 1px solid #667eea;">
                                    <i class="bi bi-layout-split"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Gutter</label>
                            <div class="d-flex align-items-center mb-2">
                                <input type="number" class="form-control form-control-sm me-2 modern-card" id="gutter" value="10" min="0" style="width: 70px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                <span style="color: #a0aec0;">px</span>
                            </div>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn active modern-card" data-gutter="left" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 1px solid #667eea;">
                                    <i class="bi bi-arrow-bar-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn modern-card" data-gutter="center" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-arrows-collapse"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn modern-card" data-gutter="right" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-arrow-bar-right"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn modern-card" data-gutter="none" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Arrangement</label>
                                <select class="form-select form-select-sm modern-card" id="arrangement" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                    <option style="background: #2d3748; color: #fff;">1 Column</option>
                                    <option style="background: #2d3748; color: #fff;">2 Columns</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Width</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control modern-card" id="width" value="66" min="1" max="100" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px 0 0 8px;">
                                    <span class="input-group-text modern-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #a0aec0; border-radius: 0 8px 8px 0;">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label mb-1">Order</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-light btn-sm order-btn active" data-order="roles">
                                        <i class="bi bi-list-ol"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm order-btn" data-order="names">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-1">Block Inset</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-light btn-sm inset-btn active" data-inset="default">
                                        <i class="bi bi-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm inset-btn" data-inset="left">
                                        <i class="bi bi-arrow-bar-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm inset-btn" data-inset="right">
                                        <i class="bi bi-arrow-bar-right"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm inset-btn" data-inset="both">
                                        <i class="bi bi-arrows-fullscreen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Margin</label>
                                <select class="form-select form-select-sm modern-card" id="margin" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                    <option style="background: #2d3748; color: #fff;">Vertical</option>
                                    <option style="background: #2d3748; color: #fff;">Horizontal</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Bottom</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control modern-card" id="marginBottom" value="0" min="0" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px 0 0 8px;">
                                    <span class="input-group-text modern-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #a0aec0; border-radius: 0 8px 8px 0;">px</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="{{ route('project.render', ['projectId' => $project->id]) }}" class="btn btn-custom w-100 btn-sm" style="border-radius: 8px; font-weight: 500; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="bi bi-play-circle"></i>
                                Render
                            </a>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-warning w-100 btn-sm" id="creaditSheet" style="background: linear-gradient(135deg, #d69e2e 0%, #b7791f 100%); border: none; border-radius: 8px; font-weight: 500; color: white;">Credits Sheet</button>
                        </div>
                        <div class="mb-2">
                            <button class="btn w-100 btn-sm" id="syncCredits" style="background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%); border: none; border-radius: 8px; font-weight: 500; color: white; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="bi bi-arrow-repeat"></i>
                                Sync Credits
                            </button>
                        </div>
                    </div>
                    <div id="fontPanel" style="display:none;">
                        <!-- Heading Typography -->
                        <div class="mb-3">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Heading</label>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="headingFontFamily" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="Noto Sans" style="background: #2d3748; color: #fff;">Noto Sans</option>
                                        <option value="Oswald" style="background: #2d3748; color: #fff;">Oswald</option>
                                        <option value="Arial" style="background: #2d3748; color: #fff;">Arial</option>
                                        <option value="Inter" style="background: #2d3748; color: #fff;">Inter</option>
                                        <option value="Roboto" style="background: #2d3748; color: #fff;">Roboto</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="headingFontWeight" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="300" style="background: #2d3748; color: #fff;">Light</option>
                                        <option value="400" style="background: #2d3748; color: #fff;">Regular</option>
                                        <option value="500" style="background: #2d3748; color: #fff;">Medium</option>
                                        <option value="600" style="background: #2d3748; color: #fff;">Semibold</option>
                                        <option value="700" style="background: #2d3748; color: #fff;">Bold</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-light" type="button" id="headingFontSizeDown" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <input type="number" class="form-control text-center modern-card" id="headingFontSize" value="24" min="8" max="72" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                        <button class="btn btn-outline-light" type="button" id="headingFontSizeUp" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-up"></i>
                                        </button>
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">px</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">A|A</span>
                                        <input type="number" class="form-control text-center modern-card" id="headingLetterSpacing" value="0" step="0.1" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">↓</span>
                                        <input type="number" class="form-control text-center modern-card" id="headingLineHeight" value="1.2" step="0.1" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm heading-style-btn" data-style="bold" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <strong>B</strong>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm heading-style-btn" data-style="italic" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <em>I</em>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm heading-style-btn" data-style="underline" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <u>U</u>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">#</span>
                                        <input type="color" class="form-control form-control-color modern-card" id="headingColor" value="#ffffff" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 2px; border-radius: 0 8px 8px 0;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub Heading Typography -->
                        <div class="mb-3">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Sub Heading</label>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="subHeadingFontFamily" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="Oswald" style="background: #2d3748; color: #fff;">Oswald</option>
                                        <option value="Noto Sans" style="background: #2d3748; color: #fff;">Noto Sans</option>
                                        <option value="Arial" style="background: #2d3748; color: #fff;">Arial</option>
                                        <option value="Inter" style="background: #2d3748; color: #fff;">Inter</option>
                                        <option value="Roboto" style="background: #2d3748; color: #fff;">Roboto</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="subHeadingFontWeight" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="300" style="background: #2d3748; color: #fff;">Light</option>
                                        <option value="400" style="background: #2d3748; color: #fff;">Regular</option>
                                        <option value="500" style="background: #2d3748; color: #fff;">Medium</option>
                                        <option value="600" style="background: #2d3748; color: #fff;">Semibold</option>
                                        <option value="700" style="background: #2d3748; color: #fff;">Bold</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-light" type="button" id="subHeadingFontSizeDown" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <input type="number" class="form-control text-center modern-card" id="subHeadingFontSize" value="12" min="8" max="48" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                        <button class="btn btn-outline-light" type="button" id="subHeadingFontSizeUp" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-up"></i>
                                        </button>
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">px</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">A|A</span>
                                        <input type="number" class="form-control text-center modern-card" id="subHeadingLetterSpacing" value="0" step="0.1" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">↓</span>
                                        <input type="number" class="form-control text-center modern-card" id="subHeadingLineHeight" value="1.2" step="0.1" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm subheading-style-btn" data-style="bold" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <strong>B</strong>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm subheading-style-btn" data-style="italic" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <em>I</em>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm subheading-style-btn" data-style="underline" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <u>U</u>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">#</span>
                                        <input type="color" class="form-control form-control-color modern-card" id="subHeadingColor" value="#ffffff" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 2px; border-radius: 0 8px 8px 0;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Typography -->
                        <div class="mb-3">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Role</label>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="roleFontFamily" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="Noto Sans" style="background: #2d3748; color: #fff;">Noto Sans</option>
                                        <option value="Oswald" style="background: #2d3748; color: #fff;">Oswald</option>
                                        <option value="Arial" style="background: #2d3748; color: #fff;">Arial</option>
                                        <option value="Inter" style="background: #2d3748; color: #fff;">Inter</option>
                                        <option value="Roboto" style="background: #2d3748; color: #fff;">Roboto</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-light" type="button" id="roleFontSizeDown" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <input type="number" class="form-control text-center modern-card" id="roleFontSize" value="8" min="6" max="24" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                        <button class="btn btn-outline-light" type="button" id="roleFontSizeUp" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-up"></i>
                                        </button>
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">PX</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name Typography -->
                        <div class="mb-3">
                            <label class="form-label mb-1" style="font-weight: 500; color: #e2e8f0;">Name</label>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-select-sm modern-card" id="nameFontFamily" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 8px;">
                                        <option value="Cooper Hewitt" style="background: #2d3748; color: #fff;">Cooper Hewitt</option>
                                        <option value="Noto Sans" style="background: #2d3748; color: #fff;">Noto Sans</option>
                                        <option value="Oswald" style="background: #2d3748; color: #fff;">Oswald</option>
                                        <option value="Arial" style="background: #2d3748; color: #fff;">Arial</option>
                                        <option value="Inter" style="background: #2d3748; color: #fff;">Inter</option>
                                        <option value="Roboto" style="background: #2d3748; color: #fff;">Roboto</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-light" type="button" id="nameFontSizeDown" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <input type="number" class="form-control text-center modern-card" id="nameFontSize" value="8" min="6" max="24" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                        <button class="btn btn-outline-light" type="button" id="nameFontSizeUp" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-up"></i>
                                        </button>
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">PX</span>
                                    </div>
                                </div>
                            </div>
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
        // Project information from server
        const PROJECT_ID = {{ $project->id }};
        const PROJECT_NAME = "{{ $project->template_name }}";
        
        console.log('Current Project:', { id: PROJECT_ID, name: PROJECT_NAME });

        // Tab switching for Layout/Font
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure the main content height is set correctly
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                mainContent.style.height = '100vh';
            }
            
            document.getElementById('layoutTab').onclick = function () {
                this.classList.add('active');
                this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                this.style.opacity = '1';
                
                document.getElementById('fontTab').classList.remove('active');
                document.getElementById('fontTab').style.background = 'rgba(255,255,255,0.1)';
                document.getElementById('fontTab').style.opacity = '0.7';
                
                document.getElementById('layoutPanel').style.display = '';
                document.getElementById('fontPanel').style.display = 'none';
            };
            document.getElementById('fontTab').onclick = function () {
                this.classList.add('active');
                this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                this.style.opacity = '1';
                
                document.getElementById('layoutTab').classList.remove('active');
                document.getElementById('layoutTab').style.background = 'rgba(255,255,255,0.1)';
                document.getElementById('layoutTab').style.opacity = '0.7';
                
                document.getElementById('layoutPanel').style.display = 'none';
                document.getElementById('fontPanel').style.display = '';
            };
        });

        // Google Sheet CSV export URL - now using Laravel route
        const csvUrl = '/api/test-direct-sheet';

        let sheetData = [];
        let blockNames = [];
        let blockOffsets = [];
        let currentTemplate = 'scroll'; // 'scroll' or 'card'
        let activeBlockIdx = 0; // Track active block index for scroll mode

        // Store per-block headings/subheadings and all settings
        let perBlockSettings = {};

        // Helper to get current block settings (moved to global scope)
        function getCurrentBlockSettings() {
            console.log('Getting settings for block:', activeBlockIdx);
            if (!perBlockSettings[activeBlockIdx]) {
                console.log('Creating new settings for block:', activeBlockIdx);
                perBlockSettings[activeBlockIdx] = getDefaultBlockSettings();
            }
            console.log('Current block settings:', perBlockSettings[activeBlockIdx]);
            return perBlockSettings[activeBlockIdx];
        }

        // Default settings for a block
        function getDefaultBlockSettings() {
            return {
                blockType: 'Role + Name',
                heading: '',
                subHeading: '',
                alignment: 'double',
                gutter: 'left',
                gutterValue: 10,
                arrangement: '1 Column',
                width: 66, // Default width set to 66%
                order: 'roles',
                blockInset: 'default',
                margin: 'Vertical',
                marginBottom: 0,
                
                // Heading Typography
                headingFontFamily: 'Noto Sans',
                headingFontSize: 24,
                headingFontWeight: 600,
                headingLetterSpacing: 0,
                headingLineHeight: 1.2,
                headingColor: '#ffffff',
                headingStyles: [], // Array for bold, italic, underline
                
                // Sub Heading Typography
                subHeadingFontFamily: 'Oswald',
                subHeadingFontSize: 12,
                subHeadingFontWeight: 400,
                subHeadingLetterSpacing: 0,
                subHeadingLineHeight: 1.2,
                subHeadingColor: '#ffffff',
                subHeadingStyles: [], // Array for bold, italic, underline
                
                // Role Typography
                roleFontFamily: 'Noto Sans',
                roleFontSize: 8,
                
                // Name Typography
                nameFontFamily: 'Cooper Hewitt',
                nameFontSize: 8,
                
                // Legacy font settings (for backward compatibility)
                fontFamily: 'Oswald',
                fontSize: 16,
                fontWeight: 600
            };
        }

        // Load settings from database with localStorage fallback
        async function loadBlockSettings() {
            try {
                console.log('Loading block settings from database for project:', PROJECT_ID, PROJECT_NAME);
                
                const response = await fetch(`/api/block-settings/load?projectId=${PROJECT_ID}&projectName=${encodeURIComponent(PROJECT_NAME)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();
                
                if (result.success && result.data.hasSettings) {
                    perBlockSettings = result.data.perBlockSettings || {};
                    console.log('Block settings loaded successfully from database');
                    
                    // Also update localStorage as backup
                    localStorage.setItem('blockSettings', JSON.stringify(perBlockSettings));
                    return true;
                } else {
                    console.log('No saved settings found in database, checking localStorage...');
                    // Fallback to localStorage
                    return loadBlockSettingsFromLocalStorage();
                }
            } catch (error) {
                console.error('Error loading block settings from database:', error);
                // Fallback to localStorage
                return loadBlockSettingsFromLocalStorage();
            }
        }
        
        // Fallback function to load from localStorage
        function loadBlockSettingsFromLocalStorage() {
            const saved = localStorage.getItem('blockSettings');
            if (saved) {
                try {
                    perBlockSettings = JSON.parse(saved);
                    console.log('Block settings loaded from localStorage fallback');
                    return true;
                } catch (e) {
                    console.warn('Error loading saved settings from localStorage:', e);
                    perBlockSettings = {};
                    return false;
                }
            }
            perBlockSettings = {};
            return false;
        }

        // Enhanced data loading with error handling
        function loadSheetDataSafely() {
            console.log('Loading sheet data for project:', PROJECT_ID);
            
            // Temporarily use the old endpoint to test
            const csvUrl = '/api/test-direct-sheet';
            
            // Fetch and parse CSV
            return new Promise((resolve, reject) => {
                console.log('Fetching data from:', csvUrl);
                fetch(csvUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(csv => {
                        console.log('CSV data received, length:', csv.length);
                        console.log('First 200 chars of CSV:', csv.substring(0, 200));
                        try {
                            const parsedData = parseCSV(csv);
                            console.log('Parsed CSV rows:', parsedData.length);
                            console.log('First few rows:', parsedData.slice(0, 5));
                            
                            if (parsedData.length === 0) {
                                throw new Error('No data found in CSV');
                            }
                            
                            // Remove the heading/instruction rows (rows 0, 1, 2, 3)
                            if (parsedData.length > 4) {
                                sheetData = parsedData.slice(4);
                            } else {
                                sheetData = parsedData;
                            }
                            
                            resolve(sheetData);
                        } catch (parseError) {
                            console.error('Error parsing CSV:', parseError);
                            reject(parseError);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching sheet data:', error);
                        
                        // Fallback to sample data
                        console.log('Using fallback sample data');
                        sheetData = [
                            ['HOW TO USE THE CREDIT SHEET?', '', '', '', '', ''],
                            ['', '', '', '', '', ''],
                            ['', '', 'Use ROLE + NAME blocks for common credits like cast and crew'],
                            ['', '', '', '', '', ''],
                            ['DCA', '', '', '', '', ''],
                            ['', 'Line Producer', 'Winnie Bong', '', '', ''],
                            ['', 'Unit Production Manager', 'Healin Keon', '', '', ''],
                            ['', 'First Assistant Director', 'Samantha Gao', '', '', ''],
                            ['', 'Second Assistant Director', 'Cutter White', '', '', ''],
                            ['', '', '', '', '', ''],
                            ['CAST', '', '', '', '', ''],
                            ['', 'HAYOUNG', 'Ji-young Yoo', '', '', ''],
                            ['', 'APPA', 'Jung Joon Ho', '', '', ''],
                            ['', 'MRS. CHOI', 'Jessica Whang', '', '', ''],
                            ['', 'UMMA', 'Abin Andrews', '', '', ''],
                            ['', 'ARA', 'Erin Choi', '', '', '']
                        ];
                        resolve(sheetData);
                    });
            });
        }

        // Enhanced initialization with better error handling
        async function initializeApp() {
            try {
                console.log('Starting app initialization...');
                console.log('Project ID:', PROJECT_ID);
                console.log('Project Name:', PROJECT_NAME);
                
                // Load block settings from database first
                await loadBlockSettings();
                
                console.log('Loading sheet data...');
                loadSheetDataSafely()
                    .then(() => {
                        console.log('Sheet data loaded successfully:', sheetData.length, 'rows');
                        console.log('Sample data:', sheetData.slice(0, 3));
                        
                        renderHeadings();
                        console.log('Block names found:', blockNames);
                        
                        if (blockNames.length > 0) {
                            activeBlockIdx = 0;
                            updateUIFromSettings();
                            renderAllBlocks();
                            console.log('App initialized successfully');
                        } else {
                            console.warn('No valid block names found');
                            document.getElementById('sheetContent').innerHTML = 
                                '<div style="color: #ff6b6b; text-align: center; padding: 2rem;">No credit blocks found. Try clicking "Sync Credits" to refresh data.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Failed to initialize app:', error);
                        document.getElementById('sheetContent').innerHTML = 
                            '<div style="color: #ff6b6b; text-align: center; padding: 2rem;">Error loading data. Please try refreshing the page.<br><small>' + error.message + '</small></div>';
                    });
            } catch (error) {
                console.error('Critical error during app initialization:', error);
            }
        }

        // Google Sheets Integration Functions
        async function openGoogleSheetForEditing() {
            try {
                console.log('Opening Google Sheet for editing...');
                
                // Show loading state
                const button = document.getElementById('creaditSheet');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-hourglass-split"></i> Opening...';
                button.disabled = true;
                
                // Get or create Google Sheet URL for this project
                const response = await fetch(`/api/project-google-sheet/${PROJECT_ID}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success && result.sheetUrl) {
                    // Open the Google Sheet in a new tab
                    window.open(result.sheetUrl, '_blank');
                    
                    // Show success message
                    showNotification('Google Sheet opened successfully!', 'success');
                } else {
                    // If no sheet exists, create a new one
                    await createNewGoogleSheet();
                }
                
            } catch (error) {
                console.error('Error opening Google Sheet:', error);
                showNotification('Failed to open Google Sheet. Please try again.', 'error');
            } finally {
                // Restore button state
                const button = document.getElementById('creaditSheet');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }
        
        async function createNewGoogleSheet() {
            try {
                console.log('Creating new Google Sheet for project...');
                
                const response = await fetch('/api/create-project-sheet', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        projectId: PROJECT_ID,
                        projectName: PROJECT_NAME
                    })
                });
                
                const result = await response.json();
                
                if (result.success && result.sheetUrl) {
                    // Open the newly created Google Sheet
                    window.open(result.sheetUrl, '_blank');
                    showNotification('New Google Sheet created and opened!', 'success');
                } else {
                    throw new Error(result.message || 'Failed to create Google Sheet');
                }
                
            } catch (error) {
                console.error('Error creating Google Sheet:', error);
                showNotification('Failed to create Google Sheet. Please contact support.', 'error');
            }
        }
        
        async function syncCreditsFromGoogleSheet() {
            try {
                console.log('Syncing credits from Google Sheet...');
                
                // Show loading state
                const button = document.getElementById('syncCredits');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Syncing...';
                button.disabled = true;
                
                // Add spin animation
                const style = document.createElement('style');
                style.textContent = `
                    .spin {
                        animation: spin 1s linear infinite;
                    }
                    @keyframes spin {
                        from { transform: rotate(0deg); }
                        to { transform: rotate(360deg); }
                    }
                `;
                document.head.appendChild(style);
                
                // Force refresh the sheet data
                const freshData = await loadSheetDataSafely();
                
                if (freshData && freshData.length > 0) {
                    // Update the UI with fresh data
                    sheetData = freshData;
                    renderHeadings();
                    
                    // If we have an active block, re-render it
                    if (blockNames.length > 0) {
                        renderAllBlocks();
                    }
                    
                    showNotification('Credits synchronized successfully!', 'success');
                } else {
                    showNotification('No data found to sync. Please check your Google Sheet.', 'warning');
                }
                
            } catch (error) {
                console.error('Error syncing credits:', error);
                showNotification('Failed to sync credits. Please try again.', 'error');
            } finally {
                // Restore button state
                const button = document.getElementById('syncCredits');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }
        
        // Utility function to show notifications
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'}`;
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
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Add slide-in animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(notification);
            
            // Auto-remove after 4 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            initializeApp();
            setupBlockTools();
        });

        function setupBlockTools() {
            // Populate tools with current block settings
            function populateTools() {
                const settings = getCurrentBlockSettings();
                
                // Update all form controls to match current block settings
                try {
                    if (document.getElementById('blockType')) {
                        document.getElementById('blockType').value = settings.blockType || 'Role + Name';
                    }
                    if (document.getElementById('heading')) {
                        document.getElementById('heading').value = settings.heading || '';
                    }
                    if (document.getElementById('subHeading')) {
                        document.getElementById('subHeading').value = settings.subHeading || '';
                    }
                    
                    updateUIFromSettings();
                } catch (error) {
                    console.warn('Error populating tools:', error);
                }
            }

            // Make populateTools available globally
            window.populateTools = populateTools;

            // Block Type
            if (document.getElementById('blockType')) {
                document.getElementById('blockType').addEventListener('change', function () {
                    getCurrentBlockSettings().blockType = this.value;
                    renderAllBlocks();
                    autoSaveSettings(); // Auto-save on change
                });
            }

            // Heading input
            if (document.getElementById('heading')) {
                document.getElementById('heading').addEventListener('input', function () {
                    getCurrentBlockSettings().heading = this.value;
                    renderAllBlocks();
                    autoSaveSettings(); // Auto-save on input
                });
            }

            // Sub Heading input
            if (document.getElementById('subHeading')) {
                document.getElementById('subHeading').addEventListener('input', function () {
                    getCurrentBlockSettings().subHeading = this.value;
                    renderAllBlocks();
                    autoSaveSettings(); // Auto-save on input
                });
            }

            // Alignment buttons
            document.querySelectorAll('.align-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.align-btn').forEach(b => {
                        b.classList.remove('active');
                        b.style.background = 'rgba(255,255,255,0.1)';
                        b.style.borderColor = 'rgba(255,255,255,0.2)';
                    });
                    this.classList.add('active');
                    this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    this.style.borderColor = '#667eea';
                    getCurrentBlockSettings().alignment = this.dataset.align;
                    renderAllBlocks();
                    autoSaveSettings(); // Auto-save on button click
                });
            });

            // Gutter controls
            if (document.getElementById('gutter')) {
                document.getElementById('gutter').addEventListener('input', function () {
                    getCurrentBlockSettings().gutterValue = parseInt(this.value) || 0;
                    renderAllBlocks();
                });
            }

            document.querySelectorAll('.gutter-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.gutter-btn').forEach(b => {
                        b.classList.remove('active');
                        b.style.background = 'rgba(255,255,255,0.1)';
                        b.style.borderColor = 'rgba(255,255,255,0.2)';
                    });
                    this.classList.add('active');
                    this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    this.style.borderColor = '#667eea';
                    getCurrentBlockSettings().gutter = this.dataset.gutter;
                    renderAllBlocks();
                });
            });

            // Arrangement
            if (document.getElementById('arrangement')) {
                document.getElementById('arrangement').addEventListener('change', function () {
                    getCurrentBlockSettings().arrangement = this.value;
                    renderAllBlocks();
                });
            }

            // Width
            if (document.getElementById('width')) {
                document.getElementById('width').addEventListener('input', function () {
                    getCurrentBlockSettings().width = parseInt(this.value) || 66;
                    renderAllBlocks();
                });
            }

            // Order buttons
            document.querySelectorAll('.order-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.order-btn').forEach(b => {
                        b.classList.remove('active');
                        b.style.background = 'rgba(255,255,255,0.1)';
                        b.style.borderColor = 'rgba(255,255,255,0.2)';
                    });
                    this.classList.add('active');
                    this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    this.style.borderColor = '#667eea';
                    getCurrentBlockSettings().order = this.dataset.order;
                    renderAllBlocks();
                });
            });

            // Block Inset buttons
            document.querySelectorAll('.inset-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.inset-btn').forEach(b => {
                        b.classList.remove('active');
                        b.style.background = 'rgba(255,255,255,0.1)';
                        b.style.borderColor = 'rgba(255,255,255,0.2)';
                    });
                    this.classList.add('active');
                    this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    this.style.borderColor = '#667eea';
                    getCurrentBlockSettings().blockInset = this.dataset.inset;
                    renderAllBlocks();
                });
            });

            // Margin controls
            if (document.getElementById('margin')) {
                document.getElementById('margin').addEventListener('change', function () {
                    getCurrentBlockSettings().margin = this.value;
                    renderAllBlocks();
                });
            }

            if (document.getElementById('marginBottom')) {
                document.getElementById('marginBottom').addEventListener('input', function () {
                    getCurrentBlockSettings().marginBottom = parseInt(this.value) || 0;
                    renderAllBlocks();
                });
            }

            // Legacy font controls
            if (document.getElementById('fontFamily')) {
                document.getElementById('fontFamily').addEventListener('change', function () {
                    getCurrentBlockSettings().fontFamily = this.value;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('fontSize')) {
                document.getElementById('fontSize').addEventListener('input', function () {
                    getCurrentBlockSettings().fontSize = parseInt(this.value) || 16;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('fontWeight')) {
                document.getElementById('fontWeight').addEventListener('change', function () {
                    getCurrentBlockSettings().fontWeight = parseInt(this.value) || 600;
                    renderAllBlocks();
                });
            }

            // Heading Font Controls
            if (document.getElementById('headingFontFamily')) {
                document.getElementById('headingFontFamily').addEventListener('change', function () {
                    console.log('Heading font family changed to:', this.value);
                    getCurrentBlockSettings().headingFontFamily = this.value;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingFontWeight')) {
                document.getElementById('headingFontWeight').addEventListener('change', function () {
                    console.log('Heading font weight changed to:', this.value);
                    getCurrentBlockSettings().headingFontWeight = parseInt(this.value) || 600;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingFontSize')) {
                document.getElementById('headingFontSize').addEventListener('input', function () {
                    console.log('Heading font size changed to:', this.value);
                    getCurrentBlockSettings().headingFontSize = parseInt(this.value) || 24;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingFontSizeUp')) {
                document.getElementById('headingFontSizeUp').addEventListener('click', function () {
                    const input = document.getElementById('headingFontSize');
                    const newValue = Math.min(parseInt(input.value) + 1, parseInt(input.max));
                    input.value = newValue;
                    getCurrentBlockSettings().headingFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingFontSizeDown')) {
                document.getElementById('headingFontSizeDown').addEventListener('click', function () {
                    const input = document.getElementById('headingFontSize');
                    const newValue = Math.max(parseInt(input.value) - 1, parseInt(input.min));
                    input.value = newValue;
                    getCurrentBlockSettings().headingFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingLetterSpacing')) {
                document.getElementById('headingLetterSpacing').addEventListener('input', function () {
                    getCurrentBlockSettings().headingLetterSpacing = parseFloat(this.value) || 0;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingLineHeight')) {
                document.getElementById('headingLineHeight').addEventListener('input', function () {
                    getCurrentBlockSettings().headingLineHeight = parseFloat(this.value) || 1.2;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('headingColor')) {
                document.getElementById('headingColor').addEventListener('input', function () {
                    getCurrentBlockSettings().headingColor = this.value;
                    renderAllBlocks();
                });
            }

            // Heading Style Buttons
            document.querySelectorAll('.heading-style-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const style = this.dataset.style;
                    const settings = getCurrentBlockSettings();
                    
                    if (!settings.headingStyles) settings.headingStyles = [];
                    
                    if (settings.headingStyles.includes(style)) {
                        settings.headingStyles = settings.headingStyles.filter(s => s !== style);
                        this.style.background = 'rgba(255,255,255,0.1)';
                        this.style.borderColor = 'rgba(255,255,255,0.2)';
                    } else {
                        settings.headingStyles.push(style);
                        this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        this.style.borderColor = '#667eea';
                    }
                    
                    renderAllBlocks();
                });
            });

            // Sub Heading Font Controls
            if (document.getElementById('subHeadingFontFamily')) {
                document.getElementById('subHeadingFontFamily').addEventListener('change', function () {
                    console.log('Sub heading font family changed to:', this.value);
                    getCurrentBlockSettings().subHeadingFontFamily = this.value;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingFontWeight')) {
                document.getElementById('subHeadingFontWeight').addEventListener('change', function () {
                    console.log('Sub heading font weight changed to:', this.value);
                    getCurrentBlockSettings().subHeadingFontWeight = parseInt(this.value) || 400;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingFontSize')) {
                document.getElementById('subHeadingFontSize').addEventListener('input', function () {
                    console.log('Sub heading font size changed to:', this.value);
                    getCurrentBlockSettings().subHeadingFontSize = parseInt(this.value) || 12;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingFontSizeUp')) {
                document.getElementById('subHeadingFontSizeUp').addEventListener('click', function () {
                    const input = document.getElementById('subHeadingFontSize');
                    const newValue = Math.min(parseInt(input.value) + 1, parseInt(input.max));
                    input.value = newValue;
                    getCurrentBlockSettings().subHeadingFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingFontSizeDown')) {
                document.getElementById('subHeadingFontSizeDown').addEventListener('click', function () {
                    const input = document.getElementById('subHeadingFontSize');
                    const newValue = Math.max(parseInt(input.value) - 1, parseInt(input.min));
                    input.value = newValue;
                    getCurrentBlockSettings().subHeadingFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingLetterSpacing')) {
                document.getElementById('subHeadingLetterSpacing').addEventListener('input', function () {
                    getCurrentBlockSettings().subHeadingLetterSpacing = parseFloat(this.value) || 0;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingLineHeight')) {
                document.getElementById('subHeadingLineHeight').addEventListener('input', function () {
                    getCurrentBlockSettings().subHeadingLineHeight = parseFloat(this.value) || 1.2;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('subHeadingColor')) {
                document.getElementById('subHeadingColor').addEventListener('input', function () {
                    getCurrentBlockSettings().subHeadingColor = this.value;
                    renderAllBlocks();
                });
            }

            // Sub Heading Style Buttons
            document.querySelectorAll('.subheading-style-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const style = this.dataset.style;
                    const settings = getCurrentBlockSettings();
                    
                    if (!settings.subHeadingStyles) settings.subHeadingStyles = [];
                    
                    if (settings.subHeadingStyles.includes(style)) {
                        settings.subHeadingStyles = settings.subHeadingStyles.filter(s => s !== style);
                        this.style.background = 'rgba(255,255,255,0.1)';
                        this.style.borderColor = 'rgba(255,255,255,0.2)';
                    } else {
                        settings.subHeadingStyles.push(style);
                        this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        this.style.borderColor = '#667eea';
                    }
                    
                    renderAllBlocks();
                });
            });

            // Role Font Controls
            if (document.getElementById('roleFontFamily')) {
                document.getElementById('roleFontFamily').addEventListener('change', function () {
                    getCurrentBlockSettings().roleFontFamily = this.value;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('roleFontSize')) {
                document.getElementById('roleFontSize').addEventListener('input', function () {
                    getCurrentBlockSettings().roleFontSize = parseInt(this.value) || 8;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('roleFontSizeUp')) {
                document.getElementById('roleFontSizeUp').addEventListener('click', function () {
                    const input = document.getElementById('roleFontSize');
                    const newValue = Math.min(parseInt(input.value) + 1, parseInt(input.max));
                    input.value = newValue;
                    getCurrentBlockSettings().roleFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('roleFontSizeDown')) {
                document.getElementById('roleFontSizeDown').addEventListener('click', function () {
                    const input = document.getElementById('roleFontSize');
                    const newValue = Math.max(parseInt(input.value) - 1, parseInt(input.min));
                    input.value = newValue;
                    getCurrentBlockSettings().roleFontSize = newValue;
                    renderAllBlocks();
                });
            }

            // Name Font Controls
            if (document.getElementById('nameFontFamily')) {
                document.getElementById('nameFontFamily').addEventListener('change', function () {
                    getCurrentBlockSettings().nameFontFamily = this.value;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('nameFontSize')) {
                document.getElementById('nameFontSize').addEventListener('input', function () {
                    getCurrentBlockSettings().nameFontSize = parseInt(this.value) || 8;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('nameFontSizeUp')) {
                document.getElementById('nameFontSizeUp').addEventListener('click', function () {
                    const input = document.getElementById('nameFontSize');
                    const newValue = Math.min(parseInt(input.value) + 1, parseInt(input.max));
                    input.value = newValue;
                    getCurrentBlockSettings().nameFontSize = newValue;
                    renderAllBlocks();
                });
            }
            if (document.getElementById('nameFontSizeDown')) {
                document.getElementById('nameFontSizeDown').addEventListener('click', function () {
                    const input = document.getElementById('nameFontSize');
                    const newValue = Math.max(parseInt(input.value) - 1, parseInt(input.min));
                    input.value = newValue;
                    getCurrentBlockSettings().nameFontSize = newValue;
                    renderAllBlocks();
                });
            }

            // Google Sheets Integration Buttons
            if (document.getElementById('creaditSheet')) {
                document.getElementById('creaditSheet').addEventListener('click', function () {
                    openGoogleSheetForEditing();
                });
            }
            
            if (document.getElementById('syncCredits')) {
                document.getElementById('syncCredits').addEventListener('click', function () {
                    syncCreditsFromGoogleSheet();
                });
            }

            // Add auto-save to all remaining controls that might not have it
            addAutoSaveToAllControls();

            // When switching block, populate tools
            window.populateTools = populateTools;
        }

        // Helper function to add auto-save to all controls
        function addAutoSaveToAllControls() {
            // Add auto-save to all input, select, and button controls
            const controls = document.querySelectorAll('#layoutPanel input, #layoutPanel select, #fontPanel input, #fontPanel select');
            controls.forEach(control => {
                if (!control.hasAutoSave) { // Prevent duplicate listeners
                    control.addEventListener('input', autoSaveSettings);
                    control.addEventListener('change', autoSaveSettings);
                    control.hasAutoSave = true;
                }
            });

            // Add auto-save to all style buttons
            const buttons = document.querySelectorAll('.align-btn, .gutter-btn, .order-btn, .inset-btn, .heading-style-btn, .subheading-style-btn');
            buttons.forEach(button => {
                if (!button.hasAutoSave) { // Prevent duplicate listeners
                    button.addEventListener('click', autoSaveSettings);
                    button.hasAutoSave = true;
                }
            });

            console.log('Added auto-save to all controls');
        }

        // Fetch and parse CSV
        function fetchSheetData() {
            console.log('Fetching data from:', csvUrl);
            fetch(csvUrl)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(csv => {
                    console.log('CSV data received, length:', csv.length);
                    sheetData = parseCSV(csv);
                    console.log('Parsed sheet data:', sheetData.length, 'rows');
                    // Remove the heading/instruction rows (rows 0, 1, 2, 3)
                    if (sheetData.length > 4) {
                        sheetData = sheetData.slice(4);
                    } else {
                        sheetData = [];
                    }
                    console.log('After removing headers:', sheetData.length, 'rows');
                    renderHeadings();
                    renderAllBlocks();
                })
                .catch(err => {
                    console.error('Error fetching sheet data:', err);
                    document.getElementById('sheetHeadings').innerHTML = '<div style="color:#aaa; padding:1rem;">Failed to load data<br>Error: ' + err.message + '</div>';
                });
        }

        // Improved CSV parser to handle quoted values and commas inside quotes
        function parseCSV(csv) {
            const rows = [];
            let row = [];
            let value = '';
            let insideQuotes = false;
            for (let i = 0; i < csv.length; i++) {
                const char = csv[i];
                if (char === '"') {
                    if (insideQuotes && csv[i + 1] === '"') {
                        value += '"';
                        i++;
                    } else {
                        insideQuotes = !insideQuotes;
                    }
                } else if (char === ',' && !insideQuotes) {
                    row.push(value);
                    value = '';
                } else if ((char === '\n' || char === '\r') && !insideQuotes) {
                    if (value !== '' || row.length > 0) {
                        row.push(value);
                        rows.push(row);
                        row = [];
                        value = '';
                    }
                    // Handle \r\n
                    if (char === '\r' && csv[i + 1] === '\n') i++;
                } else {
                    value += char;
                }
            }
            if (value !== '' || row.length > 0) {
                row.push(value);
                rows.push(row);
            }
            // Remove empty lines and trim
            return rows.map(r => r.map(cell => cell.trim())).filter(r => r.length > 0 && r.some(cell => cell.length > 0));
        }

        // Render sidebar headings from sheet, show all valid blocks (no skipping)
        function renderHeadings() {
            const container = document.getElementById('sheetHeadings');
            container.innerHTML = '';
            blockNames = [];
            for (let i = 0; i < sheetData.length; i++) {
                let block = sheetData[i][0] && sheetData[i][0].trim();
                // Skip empty, single/double quote, or only punctuation block names
                if (
                    block &&
                    !blockNames.includes(block) &&
                    block.replace(/['".,;:!?]/g, '').trim().length > 0 &&
                    block !== '"' &&
                    block !== "'"
                ) {
                    blockNames.push(block);
                }
            }

            if (blockNames.length === 0) {
                container.innerHTML = '<div style="color:#aaa; padding:1rem;">No Credit Blocks</div>';
                return;
            }

            blockNames.forEach((block, idx) => {
                const btn = document.createElement('button');
                btn.className = 'btn credit-block-btn p-3 w-100 text-start';
                btn.textContent = block;
                btn.style.color = '#fff';
                btn.style.background = 'rgba(255, 255, 255, 0.05)';
                btn.style.border = '1px solid rgba(255, 255, 255, 0.1)';
                btn.style.outline = 'none';
                btn.style.fontWeight = '500';
                btn.style.fontSize = '0.95rem';
                btn.style.borderRadius = '8px';
                btn.style.transition = 'all 0.3s ease';
                btn.style.marginBottom = '0.25rem';
                btn.onmouseover = () => {
                    if (!btn.classList.contains('active')) {
                        btn.style.background = 'rgba(255, 255, 255, 0.1)';
                        btn.style.borderColor = 'rgba(102, 126, 234, 0.5)';
                        btn.style.transform = 'translateX(4px)';
                    }
                };
                btn.onmouseout = () => {
                    if (!btn.classList.contains('active')) {
                        btn.style.background = 'rgba(255, 255, 255, 0.05)';
                        btn.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                        btn.style.transform = 'translateX(0)';
                    }
                };
                btn.onclick = () => {
                    // Remove active class from all buttons
                    document.querySelectorAll('.credit-block-btn').forEach(b => {
                        b.classList.remove('active');
                        b.style.background = 'rgba(255, 255, 255, 0.05)';
                        b.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                        b.style.boxShadow = 'none';
                        b.style.transform = 'translateX(0)';
                    });
                    
                    // Add active class to clicked button
                    btn.classList.add('active');
                    btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    btn.style.borderColor = '#667eea';
                    btn.style.boxShadow = '0 2px 8px rgba(102, 126, 234, 0.3)';
                    btn.style.transform = 'translateX(0)';
                    
                    // Use the enhanced block switching function
                    switchToBlock(idx);
                    window.populateTools();
                    scrollToBlock(idx, true);
                };
                btn.id = 'block-tab-' + idx;
                container.appendChild(btn);

                // Add a line break if the next row in sheetData is a section break (empty block name)
                if (
                    sheetData.length > 0 &&
                    idx < blockNames.length - 1
                ) {
                    let sheetIdx = sheetData.findIndex(row => row[0] && row[0].trim() === block);
                    if (
                        sheetIdx !== -1 &&
                        sheetData[sheetIdx + 1] &&
                        (!sheetData[sheetIdx + 1][0] || sheetData[sheetIdx + 1][0].trim() === '')
                    ) {
                        const hr = document.createElement('div');
                        hr.style.height = '18px';
                        hr.style.background = 'none';
                        hr.style.borderBottom = '2px solid #444';
                        hr.style.margin = '0.3rem 0 0.7rem 0';
                        container.appendChild(hr);
                    }
                }
            });

            // Auto-select first block if available
            if (blockNames.length > 0) {
                const firstBtn = document.getElementById('block-tab-0');
                if (firstBtn) {
                    firstBtn.classList.add('active');
                    firstBtn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    firstBtn.style.borderColor = '#667eea';
                    firstBtn.style.boxShadow = '0 2px 8px rgba(102, 126, 234, 0.3)';
                }
                window.populateTools();
            }
        }

        // Render all blocks for scrolling template
        function renderAllBlocks(callback) {
            try {
                console.log('Rendering all blocks...');
                const contentDiv = document.getElementById('sheetContent');
                // Remove overflow-y:auto and max-height to disable vertical/horizontal scrollbars
                contentDiv.innerHTML = `
                    <div id="all-blocks-container" style="width:100%; background:#101014; border-radius:14px; box-shadow:0 0 0 1px #222; padding:2.5rem 0;">
                    </div>
                `;
                const container = document.getElementById('all-blocks-container');
                blockOffsets = [];
                blockNames.forEach((blockName, idx) => {
                    console.log(`Rendering block ${idx}: ${blockName}`);
                    let blockRows = [];
                    let foundBlock = false;
                    for (let i = 0; i < sheetData.length; i++) {
                        if (sheetData[i][0] && sheetData[i][0].trim() === blockName) {
                            foundBlock = true;
                            continue;
                        }
                        if (foundBlock) {
                            if (sheetData[i][0] && sheetData[i][0].trim() !== '') break;
                            blockRows.push(sheetData[i]);
                        }
                    }
                    let leftCol = [];
                    let rightCol = [];
                    // Use per-block settings
                    const settings = perBlockSettings[idx] || getDefaultBlockSettings();
                    
                    // Debug logging
                    console.log(`Block ${idx} settings:`, settings);
                blockRows.forEach(row => {
                    const role = row[1] ? row[1].trim() : '';
                    const name = row[2] ? row[2].trim() : '';
                    if (settings.order === 'roles') {
                        if (role || name) {
                            leftCol.push(role);
                            rightCol.push(name);
                        }
                    } else {
                        if (role || name) {
                            leftCol.push(name);
                            rightCol.push(role);
                        }
                    }
                });
                const maxRows = Math.max(leftCol.length, rightCol.length);

                const blockSection = document.createElement('div');
                blockSection.className = 'credit-block-section';
                blockSection.id = 'credit-block-' + idx;
                blockSection.style.padding = '2rem 0 1.5rem 0';
                blockSection.style.borderBottom = '2px solid #222';
                blockSection.style.width = (settings.width || 66) + '%'; // Default width 66%
                
                // Apply margin setting
                if (settings.margin === 'Vertical') {
                    blockSection.style.margin = '0 auto'; // Center horizontally
                } else if (settings.margin === 'Horizontal') {
                    blockSection.style.margin = 'auto 0'; // Center vertically
                } else {
                    blockSection.style.margin = '0 auto'; // Default to horizontal centering
                }
                
                blockSection.style.marginBottom = settings.marginBottom + 'px';
                
                // Apply Block Inset setting
                const blockInset = settings.blockInset || 'default';
                switch(blockInset) {
                    case 'left':
                        blockSection.style.marginLeft = '0';
                        blockSection.style.marginRight = 'auto';
                        break;
                    case 'right':
                        blockSection.style.marginLeft = 'auto';
                        blockSection.style.marginRight = '0';
                        break;
                    case 'both':
                        blockSection.style.marginLeft = '10%';
                        blockSection.style.marginRight = '10%';
                        blockSection.style.width = '80%';
                        break;
                    case 'default':
                    default:
                        // Keep the existing margin setting
                        break;
                }

                // Per-block heading/subheading
                const heading = settings.heading || '';
                const subHeading = settings.subHeading || '';
                if (heading) {
                    const headingDiv = document.createElement('div');
                    headingDiv.style.fontSize = (settings.headingFontSize || 24) + 'px';
                    headingDiv.style.fontFamily = settings.headingFontFamily || 'Noto Sans';
                    headingDiv.style.letterSpacing = (settings.headingLetterSpacing || 0) + 'em';
                    headingDiv.style.lineHeight = settings.headingLineHeight || 1.2;
                    headingDiv.style.color = settings.headingColor || '#ffffff';
                    headingDiv.style.marginBottom = '0.2em';
                    headingDiv.style.textAlign = 'center';
                    
                    // Apply text decorations from headingStyles array
                    if (settings.headingStyles && settings.headingStyles.includes('bold')) {
                        headingDiv.style.fontWeight = 'bold';
                    } else {
                        headingDiv.style.fontWeight = settings.headingFontWeight || 600;
                    }
                    if (settings.headingStyles && settings.headingStyles.includes('italic')) {
                        headingDiv.style.fontStyle = 'italic';
                    }
                    if (settings.headingStyles && settings.headingStyles.includes('underline')) {
                        headingDiv.style.textDecoration = 'underline';
                    }
                    
                    headingDiv.textContent = heading;
                    blockSection.appendChild(headingDiv);
                }
                if (subHeading) {
                    const subHeadingDiv = document.createElement('div');
                    subHeadingDiv.style.fontSize = (settings.subHeadingFontSize || 12) + 'px';
                    subHeadingDiv.style.fontFamily = settings.subHeadingFontFamily || 'Oswald';
                    subHeadingDiv.style.letterSpacing = (settings.subHeadingLetterSpacing || 0) + 'em';
                    subHeadingDiv.style.lineHeight = settings.subHeadingLineHeight || 1.2;
                    subHeadingDiv.style.color = settings.subHeadingColor || '#aaa';
                    subHeadingDiv.style.marginBottom = '1em';
                    subHeadingDiv.style.textAlign = 'center';
                    
                    // Apply text decorations from subHeadingStyles array
                    if (settings.subHeadingStyles && settings.subHeadingStyles.includes('bold')) {
                        subHeadingDiv.style.fontWeight = 'bold';
                    } else {
                        subHeadingDiv.style.fontWeight = settings.subHeadingFontWeight || 400;
                    }
                    if (settings.subHeadingStyles && settings.subHeadingStyles.includes('italic')) {
                        subHeadingDiv.style.fontStyle = 'italic';
                    }
                    if (settings.subHeadingStyles && settings.subHeadingStyles.includes('underline')) {
                        subHeadingDiv.style.textDecoration = 'underline';
                    }
                    
                    subHeadingDiv.textContent = subHeading;
                    blockSection.appendChild(subHeadingDiv);
                }

                const table = document.createElement('table');
                
                // Apply arrangement setting (column layout)
                if (settings.arrangement === '2 Column') {
                    table.style.width = '100%';
                    table.style.columnCount = '2';
                    table.style.columnGap = '2rem';
                } else {
                    table.style.width = '90%';
                }
                
                // Apply alignment setting for table positioning
                switch(settings.alignment) {
                    case 'left':
                        table.style.margin = '0';
                        break;
                    case 'right':
                        table.style.margin = '0 0 0 auto';
                        break;
                    case 'center':
                        table.style.margin = '0 auto';
                        break;
                    case 'double':
                    default:
                        table.style.margin = '0 auto';
                        break;
                }
                
                table.style.borderCollapse = 'separate';
                table.style.borderSpacing = `0 ${settings.gutterValue}px`;
                
                const tbody = document.createElement('tbody');
                for (let i = 0; i < maxRows; i++) {
                    const tr = document.createElement('tr');
                    const tdRole = document.createElement('td');
                    
                    // Apply gutter setting for role column alignment
                    switch(settings.gutter) {
                        case 'left':
                            tdRole.style.textAlign = 'left';
                            break;
                        case 'center':
                            tdRole.style.textAlign = 'center';
                            break;
                        case 'right':
                            tdRole.style.textAlign = 'right';
                            break;
                        case 'none':
                            tdRole.style.textAlign = 'left';
                            break;
                        default:
                            tdRole.style.textAlign = 'left';
                            break;
                    }
                    
                    tdRole.style.padding = '0 2em 0 0';
                    tdRole.style.fontFamily = settings.roleFontFamily || settings.fontFamily || 'Noto Sans';
                    tdRole.style.letterSpacing = '0.18em';
                    tdRole.style.fontSize = (settings.roleFontSize || settings.fontSize || 8) + 'px';
                    tdRole.style.fontWeight = settings.fontWeight;
                    tdRole.style.verticalAlign = 'top';
                    tdRole.style.whiteSpace = 'pre';
                    tdRole.style.color = '#fff';
                    tdRole.textContent = leftCol[i] ? leftCol[i] : '';
                    
                    const tdName = document.createElement('td');
                    
                    // Apply gutter setting for name column alignment
                    switch(settings.gutter) {
                        case 'left':
                            tdName.style.textAlign = 'left';
                            break;
                        case 'center':
                            tdName.style.textAlign = 'center';
                            break;
                        case 'right':
                            tdName.style.textAlign = 'right';
                            break;
                        case 'none':
                            tdName.style.textAlign = 'right';
                            break;
                        default:
                            tdName.style.textAlign = 'right';
                            break;
                    }
                    
                    tdName.style.fontFamily = settings.nameFontFamily || settings.fontFamily || 'Cooper Hewitt';
                    tdName.style.fontSize = (settings.nameFontSize || settings.fontSize || 8) + 'px';
                    tdName.style.fontWeight = settings.fontWeight;
                    tdName.style.verticalAlign = 'top';
                    tdName.style.whiteSpace = 'pre';
                    tdName.style.color = '#fff';
                    tdName.textContent = rightCol[i] ? rightCol[i] : '';
                    tr.appendChild(tdRole);
                    tr.appendChild(tdName);
                    tbody.appendChild(tr);
                }
                table.appendChild(tbody);
                blockSection.appendChild(table);

                container.appendChild(blockSection);

                // Add a visual line break between blocks if the next row in sheetData is a section break (empty block name)
                if (
                    sheetData.length > 0 &&
                    idx < blockNames.length - 1
                ) {
                    let sheetIdx = sheetData.findIndex(row => row[0] && row[0].trim() === blockName);
                    if (
                        sheetIdx !== -1 &&
                        sheetData[sheetIdx + 1] &&
                        (!sheetData[sheetIdx + 1][0] || sheetData[sheetIdx + 1][0].trim() === '')
                    ) {
                        const hr = document.createElement('div');
                        hr.style.height = '18px';
                        hr.style.background = 'none';
                        hr.style.borderBottom = '2px solid #444';
                        hr.style.margin = '0.3rem 0 0.7rem 0';
                        container.appendChild(hr);
                    }
                }
            });
            // Highlight active block in sidebar
            document.querySelectorAll('#sheetHeadings button').forEach(btn => btn.classList.remove('active'));
            const btn = document.getElementById('block-tab-' + activeBlockIdx);
            if (btn) btn.classList.add('active');

            if (typeof callback === 'function') {
                setTimeout(callback, 100);
            }
            console.log('Finished rendering all blocks');
            
            // Auto-save settings after rendering (debounced)
            autoSaveSettings();
            } catch (error) {
                console.error('Error in renderAllBlocks:', error);
            }
        }

        // Debounced auto-save function to prevent excessive API calls
        let autoSaveTimeout;
        function autoSaveSettings() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(async () => {
                try {
                    await saveAllBlockSettings();
                    console.log('Auto-saved settings to database for project:', PROJECT_ID, PROJECT_NAME);
                } catch (error) {
                    console.warn('Auto-save failed:', error);
                }
            }, 1000); // Wait 1 second after last change before saving (reduced from 2 seconds for better UX)
        }

        // Update UI controls to match current block settings
        function updateUIFromSettings() {
            const settings = getCurrentBlockSettings();
            
            try {
                // Layout controls
                document.getElementById('blockType').value = settings.blockType || 'Role + Name';
                document.getElementById('heading').value = settings.heading || '';
                document.getElementById('subHeading').value = settings.subHeading || '';
                document.getElementById('gutter').value = settings.gutterValue || 10;
                document.getElementById('arrangement').value = settings.arrangement || '1 Column';
                document.getElementById('width').value = settings.width || 66;
                document.getElementById('margin').value = settings.margin || 'Vertical';
                document.getElementById('marginBottom').value = settings.marginBottom || 0;
                
                // Update alignment buttons
                document.querySelectorAll('.align-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = 'rgba(255,255,255,0.1)';
                    btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    if (btn.dataset.align === settings.alignment) {
                        btn.classList.add('active');
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    }
                });
                
                // Update gutter buttons
                document.querySelectorAll('.gutter-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = 'rgba(255,255,255,0.1)';
                    btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    if (btn.dataset.gutter === settings.gutter) {
                        btn.classList.add('active');
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    }
                });
                
                // Update order buttons
                document.querySelectorAll('.order-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = 'rgba(255,255,255,0.1)';
                    btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    if (btn.dataset.order === settings.order) {
                        btn.classList.add('active');
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    }
                });
                
                // Update inset buttons
                document.querySelectorAll('.inset-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = 'rgba(255,255,255,0.1)';
                    btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    if (btn.dataset.inset === settings.blockInset) {
                        btn.classList.add('active');
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    }
                });
                
                // Font controls (legacy)
                if (document.getElementById('fontFamily')) {
                    document.getElementById('fontFamily').value = settings.fontFamily || 'Oswald';
                }
                if (document.getElementById('fontSize')) {
                    document.getElementById('fontSize').value = settings.fontSize || 16;
                }
                if (document.getElementById('fontWeight')) {
                    document.getElementById('fontWeight').value = settings.fontWeight || 600;
                }
                
                // Advanced typography controls
                if (document.getElementById('headingFontFamily')) {
                    document.getElementById('headingFontFamily').value = settings.headingFontFamily || 'Noto Sans';
                    document.getElementById('headingFontWeight').value = settings.headingFontWeight || 600;
                    document.getElementById('headingFontSize').value = settings.headingFontSize || 24;
                    document.getElementById('headingLetterSpacing').value = settings.headingLetterSpacing || 0;
                    document.getElementById('headingLineHeight').value = settings.headingLineHeight || 1.2;
                    document.getElementById('headingColor').value = settings.headingColor || '#ffffff';
                }
                
                if (document.getElementById('subHeadingFontFamily')) {
                    document.getElementById('subHeadingFontFamily').value = settings.subHeadingFontFamily || 'Oswald';
                    document.getElementById('subHeadingFontWeight').value = settings.subHeadingFontWeight || 400;
                    document.getElementById('subHeadingFontSize').value = settings.subHeadingFontSize || 12;
                    document.getElementById('subHeadingLetterSpacing').value = settings.subHeadingLetterSpacing || 0;
                    document.getElementById('subHeadingLineHeight').value = settings.subHeadingLineHeight || 1.2;
                    document.getElementById('subHeadingColor').value = settings.subHeadingColor || '#ffffff';
                }
                
                if (document.getElementById('roleFontFamily')) {
                    document.getElementById('roleFontFamily').value = settings.roleFontFamily || 'Noto Sans';
                    document.getElementById('roleFontSize').value = settings.roleFontSize || 8;
                }
                
                if (document.getElementById('nameFontFamily')) {
                    document.getElementById('nameFontFamily').value = settings.nameFontFamily || 'Cooper Hewitt';
                    document.getElementById('nameFontSize').value = settings.nameFontSize || 8;
                }
                
                // Update heading style buttons
                document.querySelectorAll('.heading-style-btn').forEach(btn => {
                    const style = btn.dataset.style;
                    if (settings.headingStyles && settings.headingStyles.includes(style)) {
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    } else {
                        btn.style.background = 'rgba(255,255,255,0.1)';
                        btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    }
                });
                
                // Update sub heading style buttons
                document.querySelectorAll('.subheading-style-btn').forEach(btn => {
                    const style = btn.dataset.style;
                    if (settings.subHeadingStyles && settings.subHeadingStyles.includes(style)) {
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        btn.style.borderColor = '#667eea';
                    } else {
                        btn.style.background = 'rgba(255,255,255,0.1)';
                        btn.style.borderColor = 'rgba(255,255,255,0.2)';
                    }
                });
                
            } catch (error) {
                console.warn('Error updating UI from settings:', error);
            }
        }

        // Enhanced block switching with settings sync
        function switchToBlock(idx) {
            activeBlockIdx = idx;
            updateUIFromSettings();
            renderAllBlocks();
        }

        // Save all block settings to database with error handling
        async function saveAllBlockSettings() {
            try {
                console.log('Saving block settings to database for project:', PROJECT_ID, PROJECT_NAME);
                
                const response = await fetch('/api/block-settings/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        perBlockSettings: perBlockSettings,
                        projectId: PROJECT_ID,
                        projectName: PROJECT_NAME
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    console.log('Block settings saved successfully to database');
                    // Also save to localStorage as backup
                    localStorage.setItem('blockSettings', JSON.stringify(perBlockSettings));
                    return true;
                } else {
                    console.error('Failed to save block settings:', result.message);
                    // Fallback to localStorage
                    localStorage.setItem('blockSettings', JSON.stringify(perBlockSettings));
                    return false;
                }
            } catch (error) {
                console.error('Error saving block settings:', error);
                // Fallback to localStorage
                try {
                    localStorage.setItem('blockSettings', JSON.stringify(perBlockSettings));
                    return true;
                } catch (localError) {
                    console.error('Error saving to localStorage as fallback:', localError);
                    return false;
                }
            }
        }

        function scrollToBlock(idx, smooth = false) {
            // Update active block index
            activeBlockIdx = idx;
            
            // Update sidebar active state
            document.querySelectorAll('#sheetHeadings button').forEach(btn => btn.classList.remove('active'));
            const btn = document.getElementById('block-tab-' + idx);
            if (btn) btn.classList.add('active');
            
            // Get the main content container and target block
            const mainContent = document.getElementById('mainContent');
            const block = document.getElementById('credit-block-' + idx);
            
            if (mainContent && block) {
                // Calculate scroll position relative to the main content container
                const containerRect = mainContent.getBoundingClientRect();
                const blockRect = block.getBoundingClientRect();
                const scrollTop = mainContent.scrollTop;
                const targetScrollTop = scrollTop + (blockRect.top - containerRect.top) - 50; // 50px offset from top
                
                mainContent.scrollTo({
                    top: targetScrollTop,
                    behavior: smooth ? 'smooth' : 'auto'
                });
            }
        }



    </script>

@endsection