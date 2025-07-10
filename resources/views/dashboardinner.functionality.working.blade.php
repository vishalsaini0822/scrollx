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
                    <div class="p-3 fw-bold" style="color: #fff; border-bottom: 1px solid #333; font-size: 1.1rem;">Credit
                        Blocks <i class="bi bi-info-circle ms-1" style="opacity:0.7;"></i></div>
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
                        <span class="fw-bold me-2" style="font-size: 1.1rem;">Layout</span>
                        <button class="btn btn-sm btn-outline-light ms-auto" style="opacity:0.7;">Font</button>
                    </div>
                    <div class="mb-3">
                        <label for="blockType" class="form-label">Block type</label>
                        <select class="form-select" id="blockType">
                            <option>Role + Name</option>
                            <option>Name Only</option>
                            <option>Logo</option>
                            <option>Blurb</option>
                            <option>Song</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="heading" class="form-label">Heading</label>
                        <input type="text" class="form-control" id="heading">
                    </div>
                    <div class="mb-3">
                        <label for="gutter" class="form-label">Gutter</label>
                        <input type="number" class="form-control" id="gutter" value="10">
                    </div>
                    <div class="mb-3">
                        <label for="arrangement" class="form-label">Arrangement</label>
                        <select class="form-select" id="arrangement">
                            <option>1 Column</option>
                            <option>2 Columns</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Width (%)</label>
                        <input type="number" class="form-control" id="width" value="100">
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <select class="form-select" id="order">
                            <option>Roles First</option>
                            <option>Names First</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-custom w-100" onclick="alert('Render Preview')">Render</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Google Sheet CSV export URL
        const sheetId = '1lTzzW9nkwDVuMMAAZxNvxmGBPjaXVWSA4Giot64R8Jg';
        const gid = '755113121';
        const csvUrl = `https://docs.google.com/spreadsheets/d/${sheetId}/export?format=csv&gid=${gid}`;

        let sheetData = [];
        let blockNames = [];
        let blockOffsets = [];
        let currentTemplate = 'card'; // 'scroll' or 'card'

        document.addEventListener('DOMContentLoaded', () => {
            fetchSheetData();
            setupTemplateSwitcher();
        });

        function setupTemplateSwitcher() {
            // Add a toggle button for template type
            const adjustmentDiv = document.querySelector('.content-adjustment');
            if (!adjustmentDiv) return;
            const templateDiv = document.createElement('div');
            templateDiv.className = 'mb-3';
            templateDiv.innerHTML = `
                <label class="form-label">Template Type</label>
                <select class="form-select" id="templateType">
                    <option value="scroll">Scrolling</option>
                    <option value="card">Card</option>
                </select>
            `;
            adjustmentDiv.insertBefore(templateDiv, adjustmentDiv.firstChild);

            document.getElementById('templateType').addEventListener('change', (e) => {
                currentTemplate = e.target.value;
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

        // Simple CSV parser
        function parseCSV(csv) {
            // Remove empty lines and trim
            const rows = csv.split('\n').map(row => row.trim()).filter(row => row.length > 0).map(row => row.split(','));
            return rows;
        }

        // Render sidebar headings from sheet, skipping first 2 blocks
        function renderHeadings() {
            const container = document.getElementById('sheetHeadings');
            container.innerHTML = '';
            // Find all unique block names in the first column
            blockNames = [];
            for (let i = 0; i < sheetData.length; i++) {
                const block = sheetData[i][0] && sheetData[i][0].trim();
                if (block && !blockNames.includes(block)) {
                    blockNames.push(block);
                }
            }

            // Remove the first 2 block names (menus)
            blockNames = blockNames.slice(2);

            // If no blocks found, show a message
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
                    if (currentTemplate === 'card') {
                        showBlockContent(block, true);
                    } else {
                        scrollToBlock(idx);
                    }
                };
                btn.id = 'block-tab-' + idx;
                container.appendChild(btn);
            });

            // Auto-select first block if available
            if (blockNames.length > 0) {
                if (currentTemplate === 'card') {
                    showBlockContent(blockNames[0]);
                }
                document.getElementById('block-tab-0').classList.add('active');
            }
        }

        // Show content for selected block name (from first column) - CARD FUNCTIONALITY
        function showBlockContent(blockName, scrollToContent = false) {
            // Highlight active tab
            document.querySelectorAll('#sheetHeadings button').forEach(btn => btn.classList.remove('active'));
            // Find the button by text
            Array.from(document.querySelectorAll('#sheetHeadings button')).forEach(btn => {
                if (btn.textContent === blockName) btn.classList.add('active');
            });

            // Find all rows for this block
            let blockRows = [];
            let foundBlock = false;
            for (let i = 0; i < sheetData.length; i++) {
                if (sheetData[i][0] && sheetData[i][0].trim() === blockName) {
                    foundBlock = true;
                    continue;
                }
                if (foundBlock) {
                    // Stop at next block or end
                    if (sheetData[i][0] && sheetData[i][0].trim() !== '') break;
                    blockRows.push(sheetData[i]);
                }
            }

            // Build columns: left = role, right = name
            let leftCol = [];
            let rightCol = [];
            blockRows.forEach(row => {
                const role = row[1] ? row[1].trim() : '';
                const name = row[2] ? row[2].trim() : '';
                if (role || name) {
                    leftCol.push(role);
                    rightCol.push(name);
                }
            });

            // Find the max length for alignment
            const maxRows = Math.max(leftCol.length, rightCol.length);

            // Build HTML table for double column with screenshot-style design (no red border)
            let html = `
            <div id="credit-block-content" style="width:100%; display:flex; justify-content:center;">
                <div style="background:#101014; color:#fff; width:90%; margin:0 auto; border-radius:14px; box-shadow:0 0 0 1px #222; padding:2.5rem 0;">
                    <table style="width:90%; margin:0 auto; border-collapse:separate; border-spacing:0 0.5em;">
                        <tbody>
            `;
            for (let i = 0; i < maxRows; i++) {
                html += `
                    <tr>
                        <td style="text-align:left; padding:0 2em 0 0; font-family: 'Oswald', 'Consolas', monospace; letter-spacing:0.18em; font-size:1.05em; font-weight:600; vertical-align:top; white-space:pre; color:#fff;">${leftCol[i] ? leftCol[i] : ''}</td>
                        <td style="text-align:right; font-family: 'Oswald', 'Consolas', monospace; font-size:1.05em; font-weight:600; vertical-align:top; white-space:pre;">${rightCol[i] ? rightCol[i] : ''}</td>
                    </tr>
                `;
            }
            html += `
                        </tbody>
                    </table>
                </div>
            </div>
            `;

            document.getElementById('sheetContent').innerHTML = html || '<em style="color:#fff;">No data</em>';

            // Scroll to content if requested
            if (scrollToContent) {
                setTimeout(() => {
                    const content = document.getElementById('credit-block-content');
                    if (content) {
                        content.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            }
        }

        // Render all blocks for scrolling template
        function renderAllBlocks() {
            if (currentTemplate === 'scroll') {
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
                        if (role || name) {
                            leftCol.push(role);
                            rightCol.push(name);
                        }
                    });
                    const maxRows = Math.max(leftCol.length, rightCol.length);

                    // Block section
                    const blockSection = document.createElement('div');
                    blockSection.className = 'credit-block-section';
                    blockSection.id = 'credit-block-' + idx;
                    blockSection.style.padding = '2rem 0 1.5rem 0';
                    blockSection.style.borderBottom = '2px solid #222';

                    // Block heading
                    // const heading = document.createElement('div');
                    // heading.textContent = blockName;
                    // heading.style.fontWeight = 'bold';
                    // heading.style.fontSize = '1.2em';
                    // heading.style.marginBottom = '1.2em';
                    // heading.style.letterSpacing = '0.08em';
                    // heading.style.color = '#fff';
                    // blockSection.appendChild(heading);

                    // Block table
                    const table = document.createElement('table');
                    table.style.width = '90%';
                    table.style.margin = '0 auto';
                    table.style.borderCollapse = 'separate';
                    table.style.borderSpacing = '0 0.5em';
                    const tbody = document.createElement('tbody');
                    for (let i = 0; i < maxRows; i++) {
                        const tr = document.createElement('tr');
                        const tdRole = document.createElement('td');
                        tdRole.style.textAlign = 'left';
                        tdRole.style.padding = '0 2em 0 0';
                        tdRole.style.fontFamily = "'Oswald', 'Consolas', monospace";
                        tdRole.style.letterSpacing = '0.18em';
                        tdRole.style.fontSize = '1.05em';
                        tdRole.style.fontWeight = '600';
                        tdRole.style.verticalAlign = 'top';
                        tdRole.style.whiteSpace = 'pre';
                        tdRole.style.color = '#fff';
                        tdRole.textContent = leftCol[i] ? leftCol[i] : '';
                        const tdName = document.createElement('td');
                        tdName.style.textAlign = 'right';
                        tdName.style.fontFamily = "'Oswald', 'Consolas', monospace";
                        tdName.style.fontSize = '1.05em';
                        tdName.style.fontWeight = '600';
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
                });
            } else if (currentTemplate === 'card') {
                // Show the first block as a card (your card functionality)
                if (blockNames.length > 0) {
                    showBlockContent(blockNames[0]);
                }
            }
        }

        function scrollToBlock(idx) {
            document.querySelectorAll('#sheetHeadings button').forEach(btn => btn.classList.remove('active'));
            const btn = document.getElementById('block-tab-' + idx);
            if (btn) btn.classList.add('active');
            if (currentTemplate === 'scroll') {
                const container = document.getElementById('all-blocks-container');
                const block = document.getElementById('credit-block-' + idx);
                if (container && block) {
                    container.scrollTo({
                        top: block.offsetTop - container.offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
            // For card view, no scroll needed
        }
    </script>

@endsection
