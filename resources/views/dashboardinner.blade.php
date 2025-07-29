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
                                <label class="form-label mb-1">Margin</label>
                                <select class="form-select form-select-sm" id="margin">
                                    <option>Vertical</option>
                                    <option>Horizontal</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-1">Bottom</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" id="marginBottom" value="0">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-custom w-100 btn-sm" onclick="renderAllBlocks()" style="border-radius: 8px; font-weight: 500;">Render</button>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-success w-100 btn-sm" id="saveBlockSettings" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); border: none; border-radius: 8px; font-weight: 500;">Save Block Settings</button>
                        </div>
                        <div class="mb-2">
                            <button class="btn w-100 btn-sm" style="background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%); border: none; border-radius: 8px; font-weight: 500; color: white; display: flex; align-items: center; justify-content: center; gap: 8px;">
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
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-light" type="button" id="subHeadingFontSizeDown" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <input type="number" class="form-control text-center modern-card" id="subHeadingFontSize" value="12" min="8" max="48" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                        <button class="btn btn-outline-light" type="button" id="subHeadingFontSizeUp" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="bi bi-chevron-up"></i>
                                        </button>
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff;">PX</span>
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
            if (!perBlockSettings[activeBlockIdx]) {
                perBlockSettings[activeBlockIdx] = getDefaultBlockSettings();
            }
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
                headingBold: false,
                headingItalic: false,
                headingUnderline: false,
                
                // Sub Heading Typography
                subHeadingFontFamily: 'Oswald',
                subHeadingFontSize: 12,
                
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

        // Load settings from localStorage
        function loadBlockSettings() {
            const saved = localStorage.getItem('perBlockSettings');
            if (saved) {
                perBlockSettings = JSON.parse(saved);
            }
        }

        // Save settings to localStorage
        function saveBlockSettings() {
            // Send settings to server via AJAX (example using fetch)
            fetch('/save-block-settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ perBlockSettings })
            })
            .then(response => response.json())
            .then(data => {
            // Optionally handle response
            console.log('Settings saved:', data);
            })
            .catch(error => {
            console.error('Error saving settings:', error);
            });
        }

        // Load settings from localStorage
        function loadBlockSettings() {
            const saved = localStorage.getItem('blockSettings');
            if (saved) {
                try {
                    perBlockSettings = JSON.parse(saved);
                } catch (e) {
                    console.warn('Error loading saved settings:', e);
                    perBlockSettings = {};
                }
            }
        }

        // Enhanced data loading with error handling
        function loadSheetDataSafely() {
            console.log('Loading sheet data...');
            
            // Google Sheet CSV export URL - now using Laravel route
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
                        try {
                            const parsedData = parseCSV(csv);
                            console.log('Parsed CSV rows:', parsedData.length);
                            
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
        function initializeApp() {
            try {
                loadBlockSettings();
                loadSheetDataSafely()
                    .then(() => {
                        renderHeadings();
                        if (blockNames.length > 0) {
                            activeBlockIdx = 0;
                            updateUIFromSettings();
                            renderAllBlocks();
                        } else {
                            console.warn('No valid block names found');
                            document.getElementById('sheetContent').innerHTML = 
                                '<div style="color: #aaa; text-align: center; padding: 2rem;">No credit blocks found. Please check your sheet data.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Failed to initialize app:', error);
                        document.getElementById('sheetContent').innerHTML = 
                            '<div style="color: #ff6b6b; text-align: center; padding: 2rem;">Error loading data. Please try refreshing the page.</div>';
                    });
            } catch (error) {
                console.error('Critical error during app initialization:', error);
            }
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
                });
            }

            // Heading input
            if (document.getElementById('heading')) {
                document.getElementById('heading').addEventListener('input', function () {
                    getCurrentBlockSettings().heading = this.value;
                    renderAllBlocks();
                });
            }

            // Sub Heading input
            if (document.getElementById('subHeading')) {
                document.getElementById('subHeading').addEventListener('input', function () {
                    getCurrentBlockSettings().subHeading = this.value;
                    renderAllBlocks();
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
                    document.querySelectorAll('.order-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
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

            // When switching block, populate tools
            window.populateTools = populateTools;
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
            const contentDiv = document.getElementById('sheetContent');
            // Remove overflow-y:auto and max-height to disable vertical/horizontal scrollbars
            contentDiv.innerHTML = `
                <div id="all-blocks-container" style="width:100%; background:#101014; border-radius:14px; box-shadow:0 0 0 1px #222; padding:2.5rem 0;">
                </div>
            `;
            const container = document.getElementById('all-blocks-container');
            blockOffsets = [];
            blockNames.forEach((blockName, idx) => {
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
                    headingDiv.style.fontWeight = settings.headingFontWeight || 600;
                    headingDiv.style.letterSpacing = (settings.headingLetterSpacing || 0) + 'em';
                    headingDiv.style.lineHeight = settings.headingLineHeight || 1.2;
                    headingDiv.style.color = settings.headingColor || '#ffffff';
                    headingDiv.style.marginBottom = '0.2em';
                    headingDiv.style.textAlign = 'center';
                    
                    // Apply text decorations
                    if (settings.headingBold) headingDiv.style.fontWeight = 'bold';
                    if (settings.headingItalic) headingDiv.style.fontStyle = 'italic';
                    if (settings.headingUnderline) headingDiv.style.textDecoration = 'underline';
                    
                    headingDiv.textContent = heading;
                    blockSection.appendChild(headingDiv);
                }
                if (subHeading) {
                    const subHeadingDiv = document.createElement('div');
                    subHeadingDiv.style.fontSize = (settings.subHeadingFontSize || 12) + 'px';
                    subHeadingDiv.style.fontFamily = settings.subHeadingFontFamily || 'Oswald';
                    subHeadingDiv.style.color = '#aaa';
                    subHeadingDiv.style.marginBottom = '1em';
                    subHeadingDiv.style.textAlign = 'center';
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
                    document.getElementById('subHeadingFontSize').value = settings.subHeadingFontSize || 12;
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
                    if (style === 'bold' && settings.headingBold) {
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    } else if (style === 'italic' && settings.headingItalic) {
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    } else if (style === 'underline' && settings.headingUnderline) {
                        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    } else {
                        btn.style.background = 'rgba(255,255,255,0.1)';
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

        // Save all block settings to localStorage with error handling
        function saveAllBlockSettings() {
            try {
                const settingsToSave = JSON.stringify(perBlockSettings);
                localStorage.setItem('blockSettings', settingsToSave);
                console.log('Block settings saved successfully');
                return true;
            } catch (error) {
                console.error('Error saving block settings:', error);
                return false;
            }
        }
            // let indicator = document.getElementById('floating-indicator');
            // if (!indicator) {
            //     indicator = document.createElement('div');
            //     indicator.id = 'floating-indicator';
            //     indicator.style.position = 'fixed';
            //     indicator.style.top = '24px';
            //     indicator.style.left = '50%';
            //     indicator.style.transform = 'translateX(-50%)';
            //     indicator.style.background = '#23233a';
            //     indicator.style.color = '#fff';
            //     indicator.style.padding = '10px 32px';
            //     indicator.style.borderRadius = '8px';
            //     indicator.style.boxShadow = '0 2px 16px #0008';
            //     indicator.style.zIndex = '9999';
            //     indicator.style.fontWeight = '600';
            //     indicator.style.fontSize = '1.1rem';
            //     indicator.style.opacity = '0';
            //     indicator.style.transition = 'opacity 0.3s';
            //     document.body.appendChild(indicator);
            // }
            // indicator.textContent = text;
            // indicator.style.opacity = '1';
            // setTimeout(() => {
            //     indicator.style.opacity = '0';
            // }, 1800);
        // }

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