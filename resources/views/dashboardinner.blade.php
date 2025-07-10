{{-- <style>
    .dashboard-body {
        background-color: #121212;
        color: #ffffff;
        font-family: Arial, sans-serif;
    }

    header {
        background-color: #1f1f1f;
        padding: 1rem;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .sidebar {
        background-color: #2a2a2a;
        height: 100%;
        overflow-y: auto;
    }

    .sidebar button {
        width: 100%;
        text-align: left;
        color: #fff;
    }

    .sidebar button:hover,
    .sidebar button.active {
        background-color: #444;
    }

    .main-content {
        background-color: #000;
        padding: 2rem;
        overflow-y: auto;
        min-height: 100%;
        text-align: center;
    }

    .content-adjustment {
        background-color: #1f1f1f;
        padding: 1rem;
        height: 100%;
        overflow-y: auto;
    }

    .form-label,
    .form-control,
    .form-select,
    button {
        color: #fff;
    }

    .form-control,
    .form-select {
        background-color: #333;
        border-color: #555;
    }

    .btn-custom {
        background-color: #444;
        color: #fff;
        border: none;
    }

    .btn-custom:hover {
        background-color: #555;
    }
</style> --}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="dashboard-body" style="background-color: #121212; color: #fff; height: 100vh;">
        <div class="container-fluid h-100">
            <div class="row h-100" style="height: 100%;">
                <!-- Sidebar: Credit Block Menu -->
                <div class="col-2 sidebar p-0 d-flex flex-column" id="sidebarHeadings"
                    style="background-color: #181828; color: #fff; overflow-y: auto; max-height: 100vh; border-right: 1px solid #333;">
                    <div class="p-3 fw-bold" style="color: #fff; border-bottom: 1px solid #333; font-size: 1.1rem; display: flex; align-items: center; justify-content: space-between;">
                        <span>Credit Blocks</span>
                        <i class="bi bi-info-circle ms-1" style="opacity:0.7;"></i>
                    </div>
                    <div id="sheetHeadings" class="flex-grow-1"></div>
                </div>

                <!-- Main Content: Credit Block Content -->
                <div class="col-7 main-content d-flex flex-column align-items-center justify-content-center"
                    id="mainContent"
                    style="background-color: #101014; color: #fff; min-height: 100vh; border-right: 1px solid #333;">
                    <div class="w-100" id="sheetContent" style="max-width: 700px; margin: 0 auto; padding: 2rem 0;"></div>
                </div>

                <!-- Content Adjustment Tools -->
                <div class="col-3 content-adjustment d-flex flex-column"
                    style="background-color: #181828; color: #fff; min-height: 100vh;">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-group" role="group" style="width:100%;">
                            <button class="btn btn-sm btn-outline-light active" id="layoutTab" style="opacity:1; width:50%;">Layout</button>
                            <button class="btn btn-sm btn-outline-light" id="fontTab" style="opacity:0.7; width:50%;">Font</button>
                        </div>
                    </div>
                    <div id="layoutPanel">
                        <div class="mb-3">
                            <label class="form-label mb-1">Block type</label>
                            <select class="form-select form-select-sm" id="blockType">
                                <option>Role + Name</option>
                                <option>Name Only</option>
                                <option>Logo</option>
                                <option>Blurb</option>
                                <option>Song</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="heading" class="form-label mb-1">Heading</label>
                            <input type="text" class="form-control form-control-sm" id="heading">
                        </div>
                        <div class="mb-2">
                            <label for="subHeading" class="form-label mb-1">Sub-Heading</label>
                            <input type="text" class="form-control form-control-sm" id="subHeading">
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1">Alignment</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-light btn-sm align-btn" data-align="single">
                                    <i class="bi bi-list"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm align-btn active" data-align="double">
                                    <i class="bi bi-layout-split"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1">Gutter</label>
                            <div class="d-flex align-items-center mb-2">
                                <input type="number" class="form-control form-control-sm me-2" id="gutter" value="10" min="0" style="width: 70px;">
                                <span>px</span>
                            </div>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn active" data-gutter="left">
                                    <i class="bi bi-arrow-bar-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn" data-gutter="center">
                                    <i class="bi bi-arrows-collapse"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn" data-gutter="right">
                                    <i class="bi bi-arrow-bar-right"></i>
                                </button>
                                <button type="button" class="btn btn-outline-light btn-sm gutter-btn" data-gutter="none">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label mb-1">Arrangement</label>
                                <select class="form-select form-select-sm" id="arrangement">
                                    <option>1 Column</option>
                                    <option>2 Columns</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-1">Width</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" id="width" value="65" min="1" max="100">
                                    <span class="input-group-text">%</span>
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
                            <button class="btn btn-custom w-100 btn-sm" onclick="renderAllBlocks()">Render</button>
                        </div>
                    </div>
                    <div id="fontPanel" style="display:none;">
                        <div class="mb-2">
                            <label class="form-label mb-1">Font Family</label>
                            <select class="form-select form-select-sm" id="fontFamily">
                                <option value="Oswald">Oswald</option>
                                <option value="Arial">Arial</option>
                                <option value="Consolas">Consolas</option>
                                <option value="monospace">Monospace</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1">Font Size</label>
                            <input type="number" class="form-control form-control-sm" id="fontSize" value="16">
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1">Font Weight</label>
                            <select class="form-select form-select-sm" id="fontWeight">
                                <option value="400">Normal</option>
                                <option value="600">Semi Bold</option>
                                <option value="700">Bold</option>
                            </select>
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
            document.getElementById('layoutTab').onclick = function () {
                this.classList.add('active');
                document.getElementById('fontTab').classList.remove('active');
                document.getElementById('layoutPanel').style.display = '';
                document.getElementById('fontPanel').style.display = 'none';
            };
            document.getElementById('fontTab').onclick = function () {
                this.classList.add('active');
                document.getElementById('layoutTab').classList.remove('active');
                document.getElementById('layoutPanel').style.display = 'none';
                document.getElementById('fontPanel').style.display = '';
            };
        });

        // Google Sheet CSV export URL
        const sheetId = '1lTzzW9nkwDVuMMAAZxNvxmGBPjaXVWSA4Giot64R8Jg';
        const gid = '755113121';
        const csvUrl = `https://docs.google.com/spreadsheets/d/${sheetId}/export?format=csv&gid=${gid}`;

        let sheetData = [];
        let blockNames = [];
        let blockOffsets = [];
        let currentTemplate = 'scroll'; // 'scroll' or 'card'
        let activeBlockIdx = 0; // Track active block index for scroll mode

        // Store per-block headings/subheadings
        let perBlockSettings = {};

        // UI state for block tools (global settings)
        let blockSettings = {
            alignment: 'double',
            gutter: 'left',
            gutterValue: 10,
            arrangement: '1 Column',
            width: 40,
            order: 'roles',
            blockInset: 'default',
            margin: 'Vertical',
            marginBottom: 0,
            fontFamily: 'Oswald',
            fontSize: 16,
            fontWeight: 600
        };

        document.addEventListener('DOMContentLoaded', () => {
            fetchSheetData();
            setupBlockTools();
        });

        function setupBlockTools() {
            // Heading
            document.getElementById('heading').addEventListener('input', function () {
                perBlockSettings[activeBlockIdx] = perBlockSettings[activeBlockIdx] || {};
                perBlockSettings[activeBlockIdx].heading = this.value;
                renderAllBlocks(() => {
                    // Scroll to the block after heading is added
                    scrollToBlock(activeBlockIdx, true);
                });
            });
            // Sub-Heading
            document.getElementById('subHeading').addEventListener('input', function () {
                perBlockSettings[activeBlockIdx] = perBlockSettings[activeBlockIdx] || {};
                perBlockSettings[activeBlockIdx].subHeading = this.value;
                renderAllBlocks(() => {
                    scrollToBlock(activeBlockIdx, true);
                });
            });
            // Alignment
            document.querySelectorAll('.align-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.align-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    blockSettings.alignment = this.dataset.align;
                    renderAllBlocks();
                });
            });
            // Gutter
            document.getElementById('gutter').addEventListener('input', function () {
                blockSettings.gutterValue = parseInt(this.value) || 0;
                renderAllBlocks();
            });
            document.querySelectorAll('.gutter-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.gutter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    blockSettings.gutter = this.dataset.gutter;
                    renderAllBlocks();
                });
            });
            // Arrangement
            document.getElementById('arrangement').addEventListener('change', function () {
                blockSettings.arrangement = this.value;
                renderAllBlocks();
            });
            // Width
            // Width
            document.getElementById('width').addEventListener('input', function () {
                blockSettings.width = parseInt(this.value) || 65;
                renderAllBlocks();
            });
            // Set initial value and trigger render on load
            blockSettings.width = parseInt(document.getElementById('width').value) || 65;
            renderAllBlocks();
            // Order
            document.querySelectorAll('.order-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.order-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    blockSettings.order = this.dataset.order;
                    renderAllBlocks();
                });
            });
            // Block Inset
            document.querySelectorAll('.inset-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.inset-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    blockSettings.blockInset = this.dataset.inset;
                    renderAllBlocks();
                });
            });
            // Margin
            document.getElementById('margin').addEventListener('change', function () {
                blockSettings.margin = this.value;
                renderAllBlocks();
            });
            // Margin Bottom
            document.getElementById('marginBottom').addEventListener('input', function () {
                blockSettings.marginBottom = parseInt(this.value) || 0;
                renderAllBlocks();
            });
            // Font controls
            document.getElementById('fontFamily').addEventListener('change', function () {
                blockSettings.fontFamily = this.value;
                renderAllBlocks();
            });
            document.getElementById('fontSize').addEventListener('input', function () {
                blockSettings.fontSize = parseInt(this.value) || 16;
                renderAllBlocks();
            });
            document.getElementById('fontWeight').addEventListener('change', function () {
                blockSettings.fontWeight = parseInt(this.value) || 600;
                renderAllBlocks();
            });
        }

        // Fetch and parse CSV
        function fetchSheetData() {
            fetch(csvUrl)
                .then(response => response.text())
                .then(csv => {
                    sheetData = parseCSV(csv);
                    // Remove the heading/instruction rows (rows 0, 1, 2, 3)
                    if (sheetData.length > 4) {
                        sheetData = sheetData.slice(4);
                    } else {
                        sheetData = [];
                    }
                    renderHeadings();
                    renderAllBlocks();
                })
                .catch(err => {
                    document.getElementById('sheetHeadings').innerHTML = '<div style="color:#aaa; padding:1rem;">Failed to load data</div>';
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
                btn.className = 'btn tab p-3 w-100 text-start';
                btn.textContent = block;
                btn.style.color = '#fff';
                btn.style.background = 'none';
                btn.style.border = 'none';
                btn.style.outline = 'none';
                btn.style.fontWeight = '500';
                btn.style.fontSize = '1rem';
                btn.style.borderRadius = '0';
                btn.style.transition = 'background 0.2s';
                btn.onmouseover = () => btn.style.background = '#23233a';
                btn.onmouseout = () => btn.style.background = 'none';
                btn.onclick = () => {
                    activeBlockIdx = idx;
                    renderAllBlocks(() => {
                        scrollToBlock(idx, true);
                    });
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
                document.getElementById('block-tab-0').classList.add('active');
            }
        }

        // Render all blocks for scrolling template
        function renderAllBlocks(callback) {
            const contentDiv = document.getElementById('sheetContent');
            contentDiv.innerHTML = `
                <div id="all-blocks-container" style="width:100%; max-height:600px; overflow-y:auto; background:#101014; border-radius:14px; box-shadow:0 0 0 1px #222; padding:2.5rem 0;">
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
                blockRows.forEach(row => {
                    const role = row[1] ? row[1].trim() : '';
                    const name = row[2] ? row[2].trim() : '';
                    if (blockSettings.order === 'roles') {
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
                blockSection.style.width = blockSettings.width + '%';
                blockSection.style.margin = blockSettings.margin === 'Vertical' ? '0 auto' : 'auto 0';
                blockSection.style.marginBottom = blockSettings.marginBottom + 'px';

                // Per-block heading/subheading
                const heading = (perBlockSettings[idx] && perBlockSettings[idx].heading) || '';
                const subHeading = (perBlockSettings[idx] && perBlockSettings[idx].subHeading) || '';
                if (heading) {
                    const headingDiv = document.createElement('div');
                    headingDiv.style.fontSize = '2rem';
                    headingDiv.style.fontWeight = 'bold';
                    headingDiv.style.marginBottom = '0.2em';
                    headingDiv.style.textAlign = 'center';
                    headingDiv.textContent = heading;
                    blockSection.appendChild(headingDiv);

                    // Show a floating indicator at the top when heading is added/changed
                    if (idx === activeBlockIdx) {
                        showFloatingIndicator('Heading added: "' + heading + '"');
                    }
                }
                if (subHeading) {
                    const subHeadingDiv = document.createElement('div');
                    subHeadingDiv.style.fontSize = '1.1rem';
                    subHeadingDiv.style.color = '#aaa';
                    subHeadingDiv.style.marginBottom = '1em';
                    subHeadingDiv.style.textAlign = 'center';
                    subHeadingDiv.textContent = subHeading;
                    blockSection.appendChild(subHeadingDiv);

                    if (idx === activeBlockIdx) {
                        showFloatingIndicator('Sub-Heading added: "' + subHeading + '"');
                    }
                }

                const table = document.createElement('table');
                table.style.width = '90%';
                table.style.margin = '0 auto';
                table.style.borderCollapse = 'separate';
                table.style.borderSpacing = `0 ${blockSettings.gutterValue}px`;
                const tbody = document.createElement('tbody');
                for (let i = 0; i < maxRows; i++) {
                    const tr = document.createElement('tr');
                    const tdRole = document.createElement('td');
                    tdRole.style.textAlign = 'left';
                    tdRole.style.padding = '0 2em 0 0';
                    tdRole.style.fontFamily = blockSettings.fontFamily;
                    tdRole.style.letterSpacing = '0.18em';
                    tdRole.style.fontSize = blockSettings.fontSize + 'px';
                    tdRole.style.fontWeight = blockSettings.fontWeight;
                    tdRole.style.verticalAlign = 'top';
                    tdRole.style.whiteSpace = 'pre';
                    tdRole.style.color = '#fff';
                    tdRole.textContent = leftCol[i] ? leftCol[i] : '';
                    const tdName = document.createElement('td');
                    tdName.style.textAlign = 'right';
                    tdName.style.fontFamily = blockSettings.fontFamily;
                    tdName.style.fontSize = blockSettings.fontSize + 'px';
                    tdName.style.fontWeight = blockSettings.fontWeight;
                    tdName.style.verticalAlign = 'top';
                    tdName.style.whiteSpace = 'pre';
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

        // Show a floating indicator at the top of the main content when heading/subheading is added
        function showFloatingIndicator(text) {
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
        }

        function scrollToBlock(idx, smooth = false) {
            document.querySelectorAll('#sheetHeadings button').forEach(btn => btn.classList.remove('active'));
            const btn = document.getElementById('block-tab-' + idx);
            if (btn) btn.classList.add('active');
            const container = document.getElementById('all-blocks-container');
            const block = document.getElementById('credit-block-' + idx);
            if (container && block) {
                container.scrollTo({
                    top: block.offsetTop - container.offsetTop,
                    behavior: smooth ? 'smooth' : 'auto'
                });
            }
        }
    </script>

@endsection
