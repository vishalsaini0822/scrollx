<style>
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
    .form-label, .form-control, .form-select, button {
      color: #fff;
    }
    .form-control, .form-select {
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
  </style>



<div class="dashboard-body">
    <div class="container-fluid">
        <div class="row" style="height: calc(100vh - 70px);">
        <div class="col-2 sidebar p-0">
            <button class="btn tab p-3" onclick="showContent('dga')">DGA</button>
            <button class="btn tab p-3" onclick="showContent('cast')">CAST</button>
            <button class="btn tab p-3" onclick="showContent('stunts')">STUNTS</button>
            <button class="btn tab p-3" onclick="showContent('camera')">CAMERA</button>
            <!-- Add more tabs as needed -->
        </div>

        <div class="col-7 main-content" id="mainContent">
            <div id="dga" class="content-block">Line Producer: Winnie Bong<br>Unit Production Manager: Hanh Keon</div>
            <div id="cast" class="content-block" style="display:none">Jiyoung Yoo, Jung Joon Ho, Jessica Hwang, etc.</div>
            <div id="stunts" class="content-block" style="display:none">Stunt Coordinator: Samantha Gao<br>Choreographer: Andrew Freeman</div>
            <div id="camera" class="content-block" style="display:none">Camera Operators, Focus Pullers, etc.</div>
        </div>

        <div class="col-3 content-adjustment">
            <div class="mb-3">
            <label for="heading" class="form-label">Heading</label>
            <input type="text" class="form-control" id="heading">
            </div>
            <div class="mb-3">
            <label for="subHeading" class="form-label">Sub-Heading</label>
            <input type="text" class="form-control" id="subHeading">
            </div>
            <div class="mb-3">
            <label for="alignment" class="form-label">Alignment</label>
            <select class="form-select" id="alignment">
                <option>Single Column</option>
                <option selected>Double Column</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="gutter" class="form-label">Gutter (px)</label>
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
    function showContent(tabId) {
      document.querySelectorAll('.content-block').forEach(el => el.style.display = 'none');
      document.getElementById(tabId).style.display = 'block';

      document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');
    }
  </script>