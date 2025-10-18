<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lab Inventory Management System</title>
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar">
  <div class="nav-container">
    <div class="nav-brand">
      <i class="fas fa-laptop-code"></i>
      <span>Inventory</span>
    </div>
    <div class="nav-menu" id="navMenu">
      <a href="#dashboard" class="nav-link active" data-page="dashboard">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
      <a href="#inventory" class="nav-link" data-page="inventory">
        <i class="fas fa-list"></i>
        <span>Inventory</span>
      </a>
      <a href="#printers" class="nav-link" data-page="printers">
        <i class="fas fa-print"></i>
        <span>Printers</span>
      </a>
      <a href="#switches" class="nav-link" data-page="switches">
        <i class="fas fa-network-wired"></i>
        <span>Switches</span>
      </a>
      <a href="#racks" class="nav-link" data-page="racks">
        <i class="fas fa-server"></i>
        <span>Racks</span>
      </a>
      <a href="#cameras" class="nav-link" data-page="cameras">
        <i class="fas fa-video"></i>
        <span>Cameras</span>
      </a>
      <!-- <a href="#reports" class="nav-link" data-page="reports">
        <i class="fas fa-chart-bar"></i>
        <span>Reports</span>
      </a> -->
      <a href="#settings" class="nav-link" data-page="settings">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </div>
    <div class="nav-toggle" id="navToggle">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
  </div>
</nav>

<!-- Main Content Area -->
<main class="main-content">
  <!-- Dashboard Page -->
  <div id="dashboard" class="page active">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-tachometer-alt"></i> Lab Inventory Dashboard</h1>
        <p class="subtitle">Comprehensive overview of all lab assets and analytics</p>
      </div>
      
      <!-- Overview Stats Grid -->
      <div class="dashboard-stats-grid">
        <div class="stat-card primary">
          <div class="stat-icon">
            <i class="fas fa-desktop"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalSystems">0</h3>
            <p>Lab Systems</p>
            <span class="stat-trend" id="systemsTrend">+0 this month</span>
          </div>
        </div>
        
        <div class="stat-card success">
          <div class="stat-icon">
            <i class="fas fa-print"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalPrinters">0</h3>
            <p>Printers</p>
            <span class="stat-trend" id="printersTrend">Active devices</span>
          </div>
        </div>
        
        <div class="stat-card warning">
          <div class="stat-icon">
            <i class="fas fa-network-wired"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalSwitches">0</h3>
            <p>Network Switches</p>
            <span class="stat-trend" id="switchesTrend">Network devices</span>
          </div>
        </div>
        
        <div class="stat-card info">
          <div class="stat-icon">
            <i class="fas fa-server"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalRacks">0</h3>
            <p>Server Racks</p>
            <span class="stat-trend" id="racksTrend">Infrastructure</span>
          </div>
        </div>

        <div class="stat-card purple">
          <div class="stat-icon">
            <i class="fas fa-video"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalCameras">0</h3>
            <p>CCTV Cameras</p>
            <span class="stat-trend" id="camerasTrend">Security systems</span>
          </div>
        </div>
        
        <div class="stat-card dark">
          <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
          </div>
          <div class="stat-content">
            <h3 id="totalValue">₹0</h3>
            <p>Total Investment</p>
            <span class="stat-trend" id="valueTrend">Asset value</span>
          </div>
        </div>
      </div>

      <!-- Analytics Section -->
      <div class="dashboard-analytics">
        <!-- Department Breakdown -->
        <div class="analytics-card">
          <div class="card-header">
            <h3><i class="fas fa-building"></i> Department Distribution</h3>
            <p>Asset distribution across departments</p>
          </div>
          <div class="card-content">
            <div class="chart-scroll-container">
              <canvas id="departmentChart" width="600" height="400"></canvas>
            </div>
          </div>
        </div>

        <!-- Asset Type Breakdown -->
        <div class="analytics-card">
          <div class="card-header">
            <h3><i class="fas fa-chart-pie"></i> Asset Categories</h3>
            <p>Distribution by asset type</p>
          </div>
          <div class="card-content">
            <div class="chart-scroll-container">
              <canvas id="assetTypeChart" width="500" height="400"></canvas>
            </div>
          </div>
        </div>

        <!-- Value Distribution -->
        <div class="analytics-card">
          <div class="card-header">
            <h3><i class="fas fa-chart-bar"></i> Investment by Category</h3>
            <p>Cost breakdown across asset types</p>
          </div>
          <div class="card-content">
            <div class="chart-scroll-container">
              <canvas id="valueChart" width="600" height="400"></canvas>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="analytics-card">
          <div class="card-header">
            <h3><i class="fas fa-clock"></i> Recent Activity</h3>
            <p>Latest system updates and additions</p>
          </div>
          <div class="card-content">
            <div id="recentActivity" class="activity-list">
              <!-- Activity items will be populated here -->
            </div>
          </div>
        </div>

        <!-- Department Details Table -->
        <div class="analytics-card full-width">
          <div class="card-header">
            <h3><i class="fas fa-table"></i> Department Summary</h3>
            <p>Detailed breakdown by department</p>
          </div>
          <div class="card-content">
            <div class="table-container">
              <table id="departmentSummaryTable" class="summary-table">
                <thead>
                  <tr>
                    <th>Department</th>
                    <th>Systems</th>
                    <th>Printers</th>
                    <th>Switches</th>
                    <th>Racks</th>
                    <th>Cameras</th>
                    <th>Total Assets</th>
                    <th>Total Value</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Data will be populated here -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Inventory Page -->
  <div id="inventory" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-list"></i> System Inventory</h1>
        <p class="subtitle">Manage your lab equipment and systems</p>
      </div>
  
      <div class="controls">
        <button id="addNewBtn">+ Add New</button>
        <button id="downloadExcelBtn">📊 Download Excel</button>
        <div class="search-container">
          <input type="text" id="searchBox" placeholder="Search inventory...">
        </div>
      </div>
      
      <div class="table-container">
        <table id="inventoryTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Dept</th>
              <th>Lab</th>
              <th>Make</th>
              <th>Model</th>
              <th>Serial</th>
              <th>Processor</th>
              <th>Generation</th>
              <th>RAM</th>
              <th>Primary Storage</th>
              <th>Secondary Storage</th>
              <th>OS</th>
              <th>GPU</th>
              <th>Monitor Type</th>
              <th>Monitor Size</th>
              <th>Monitor Serial</th>
              <th>Qty</th>
              <th>Cost</th>
              <th>Reg No</th>
              <th>P No</th>
              <th>DOP</th>
              <th>Remarks</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Printers Page -->
  <div id="printers" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-print"></i> Printer Management</h1>
        <p class="subtitle">Manage printer inventory and details</p>
      </div>
      
      <div class="printer-controls">
        <button id="addPrinterBtn">+ Add New Printer</button>
        <button id="downloadPrinterExcelBtn">📊 Download Excel</button>
        <div class="search-container">
          <input type="text" id="printerSearchBox" placeholder="Search printers...">
        </div>
      </div>
      
      <div class="table-container">
        <table id="printerTable">
          <thead>
            <tr>
              <th>S No.</th>
              <th>Dept</th>
              <th>Lab Name</th>
              <th>Make</th>
              <th>Model</th>
              <th>Type</th>
              <th>Paper Size</th>
              <th>Cartridge Model</th>
              <th>Total Printers</th>
              <th>Cost</th>
              <th>Reg No</th>
              <th>P No</th>
              <th>DOP</th>
              <th>Remarks</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Reports Page -->
  <!-- <div id="reports" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-chart-bar"></i> Reports & Analytics</h1>
        <p class="subtitle">Generate detailed reports and view analytics</p>
      </div>
      
      <div class="reports-grid">
        <div class="report-card">
          <div class="report-header">
            <h3><i class="fas fa-chart-pie"></i> Department Distribution</h3>
            <button class="btn-secondary" onclick="generateDepartmentReport()">Generate</button>
          </div>
          <div class="report-content">
            <canvas id="deptPieChart" width="300" height="200"></canvas>
          </div>
        </div>
        
        <div class="report-card">
          <div class="report-header">
            <h3><i class="fas fa-chart-line"></i> Cost Analysis</h3>
            <button class="btn-secondary" onclick="generateCostReport()">Generate</button>
          </div>
          <div class="report-content">
            <canvas id="costChart" width="300" height="200"></canvas>
          </div>
        </div>
        
        <div class="report-card">
          <div class="report-header">
            <h3><i class="fas fa-calendar-check"></i> Purchase Timeline</h3>
            <button class="btn-secondary" onclick="generateTimelineReport()">Generate</button>
          </div>
          <div class="report-content">
            <canvas id="timelineChart" width="300" height="200"></canvas>
          </div>
        </div>
        
        <div class="report-card">
          <div class="report-header">
            <h3><i class="fas fa-download"></i> Export Reports</h3>
            <button class="btn-secondary" onclick="exportAllReports()">Export All</button>
          </div>
          <div class="report-content">
            <div class="export-options">
              <button class="btn-outline" onclick="exportPDF()">PDF Report</button>
              <button class="btn-outline" onclick="exportCSV()">CSV Data</button>
              <button class="btn-outline" onclick="exportExcel()">Excel Report</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <!-- Switches Page -->
  <div id="switches" class="page">
  <div class="container">
    <div class="page-header">
      <h1><i class="fas fa-network-wired"></i> Switch Management</h1>
      <p class="subtitle">Manage network switches and networking equipment</p>
    </div>

    <div class="controls">
      <button id="addSwitchBtn">+ Add New Switch</button>
      <button id="downloadSwitchExcelBtn">📊 Download Excel</button>
      <div class="search-container">
        <input type="text" id="switchSearchBox" placeholder="Search switches...">
      </div>
    </div>

    <div class="table-container">
      <table id="switchesTable">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Department</th>
            <th>Laboratory/Location</th>
            <th>Make</th>
            <th>Model</th>
            <th>Serial Number</th>
            <th>PoE/Non-PoE</th>
            <th>Access Port</th>
            <th>No. of T Ports</th>
            <th>T Ports Speed</th>
            <th>SFP Ports</th>
            <th>SFP Ports Speed</th>
            <th>Uplink SFP Ports</th>
            <th>Uplink SFP Ports Speed</th>
            <th>Register Number</th>
            <th>Page Number</th>
            <th>QTY</th>
            <th>Price in Rs.</th>
            <th>Date of Purchase</th>
            <th>Supplier Name</th>
            <th>Switch IP</th>
            <th>Remarks</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

  <!-- Racks Page -->
  <div id="racks" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-server"></i> Network Rack Management</h1>
        <p class="subtitle">Manage network rack details</p>
      </div>
      <div class="controls">
        <button id="addRackBtn">+ Add New Rack</button>
        <button id="downloadRackExcelBtn">📊 Download Excel</button>
        <div class="search-container">
          <input type="text" id="rackSearchBox" placeholder="Search racks...">
        </div>
      </div>
      <div class="table-container">
        <table id="racksTable">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Department</th>
              <th>Laboratory/Location</th>
              <th>Make</th>
              <th>Size</th>
              <th>Power Distribution Unit</th>
              <th>Register Number</th>
              <th>Page Number</th>
              <th>Price in Rs.</th>
              <th>Date of Purchase</th>
              <th>Supplier Name</th>
              <th>Remarks</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Cameras Page -->
  <div id="cameras" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-video"></i> CCTV Camera Management</h1>
        <p class="subtitle">Manage CCTV camera inventory and details</p>
      </div>
      <div class="controls">
        <button id="addCameraBtn">+ Add New Camera</button>
        <button id="downloadCameraExcelBtn">📊 Download Excel</button>
        <div class="search-container">
          <input type="text" id="cameraSearchBox" placeholder="Search cameras..." onkeyup="searchCameraTable()">
        </div>
      </div>
      <div class="table-container">
        <table id="camerasTable">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Building / Block</th>
              <th>Location</th>
              <th>Make</th>
              <th>Model</th>
              <th>Type</th>
              <th>Pixel</th>
              <th>QTY</th>
              <th>Cost</th>
              <th>Reg No</th>
              <th>P. No</th>
              <th>D.O.P</th>
              <th>Remarks</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Settings Page -->
  <div id="settings" class="page">
    <div class="container">
      <div class="page-header">
        <h1><i class="fas fa-cog"></i> Settings</h1>
        <p class="subtitle">Configure your inventory management system</p>
      </div>
      
      <div class="settings-grid">
        <!-- <div class="settings-section">
          <h3><i class="fas fa-database"></i> Database Settings</h3>
          <div class="form-group">
            <label>Database Host</label>
            <input type="text" id="dbHost" placeholder="localhost">
          </div>
          <div class="form-group">
            <label>Database Name</label>
            <input type="text" id="dbName" placeholder="lab_inventory">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" id="dbUser" placeholder="username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" id="dbPass" placeholder="password">
          </div>
          <button class="btn-primary" onclick="saveDatabaseSettings()">Save Database Settings</button>
        </div> -->
        
        <div class="settings-section">
          <h3><i class="fas fa-building"></i> Department Management</h3>
          <div class="form-group">
            <label>Add New Department</label>
            <div class="input-group">
              <input type="text" id="newDept" placeholder="Department name">
              <button class="btn-primary" onclick="addDepartment()">Add</button>
            </div>
          </div>
          <div class="department-list" id="departmentList">
            <!-- Departments will be populated here -->
          </div>
        </div>
        
        <div class="settings-section">
          <h3><i class="fas fa-palette"></i> Appearance</h3>
          <div class="form-group">
            <label for="themeSelect">Theme</label>
            <select id="themeSelect" title="Select application theme">
              <option value="light">Light Theme</option>
              <option value="dark">Dark Theme</option>
              <option value="auto">Auto (System)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="languageSelect">Language</label>
            <select id="languageSelect" title="Select application language">
              <option value="en">English</option>
              <option value="hi">Hindi</option>
            </select>
          </div>
          <button class="btn-primary" onclick="saveAppearanceSettings()">Save Appearance</button>
        </div>
        
        <!-- <div class="settings-section">
          <h3><i class="fas fa-shield-alt"></i> Security</h3>
          <div class="form-group">
            <label for="sessionTimeout">Session Timeout (minutes)</label>
            <input type="number" id="sessionTimeout" value="30" min="5" max="480" title="Session timeout in minutes">
          </div>
          <div class="form-group">
            <label for="enable2FA">Enable Two-Factor Authentication</label>
            <input type="checkbox" id="enable2FA" title="Enable two-factor authentication">
          </div>
          <button class="btn-primary" onclick="saveSecuritySettings()">Save Security Settings</button>
        </div> -->
      </div>
    </div>
  </div>
</main>

<script>
// Navigation functionality
function initNavigation() {
  const navLinks = document.querySelectorAll('.nav-link');
  const pages = document.querySelectorAll('.page');
  const navToggle = document.getElementById('navToggle');
  const navMenu = document.getElementById('navMenu');

  // Handle navigation clicks
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetPage = link.getAttribute('data-page');
      showPage(targetPage);
      
      // Update active nav link
      navLinks.forEach(l => l.classList.remove('active'));
      link.classList.add('active');
      
      // Close mobile menu
      navMenu.classList.remove('active');
    });
  });

  // Mobile menu toggle
  navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
  });

  // Handle browser back/forward buttons
  window.addEventListener('popstate', (e) => {
    const page = window.location.hash.substring(1) || 'dashboard';
    showPage(page);
    updateActiveNavLink(page);
  });

  // Initialize with current hash or dashboard
  const currentPage = window.location.hash.substring(1) || 'dashboard';
  showPage(currentPage);
  updateActiveNavLink(currentPage);
}

function showPage(pageId) {
  const pages = document.querySelectorAll('.page');
  pages.forEach(page => {
    page.classList.remove('active');
  });
  
  const targetPage = document.getElementById(pageId);
  if (targetPage) {
    targetPage.classList.add('active');
    window.location.hash = pageId;
    
    // Load page-specific data
    if (pageId === 'dashboard') {
      loadDashboardData();
    } else if (pageId === 'printers') {
      loadPrinterData();
      // Re-initialize printer button event listeners
      const addPrinterBtn = document.getElementById('addPrinterBtn');
      const downloadPrinterExcelBtn = document.getElementById('downloadPrinterExcelBtn');
      const printerSearchBox = document.getElementById('printerSearchBox');
      
      if (addPrinterBtn && !addPrinterBtn.hasAttribute('data-listener-attached')) {
        addPrinterBtn.addEventListener('click', addNewPrinter);
        addPrinterBtn.setAttribute('data-listener-attached', 'true');
      }
      if (downloadPrinterExcelBtn && !downloadPrinterExcelBtn.hasAttribute('data-listener-attached')) {
        downloadPrinterExcelBtn.addEventListener('click', downloadPrinterExcel);
        downloadPrinterExcelBtn.setAttribute('data-listener-attached', 'true');
      }
      if (printerSearchBox && !printerSearchBox.hasAttribute('data-listener-attached')) {
        printerSearchBox.addEventListener('input', searchPrinterTable);
        printerSearchBox.setAttribute('data-listener-attached', 'true');
      }
    } else if (pageId === 'switches') {
      loadSwitches();
      // Re-initialize switch button event listeners
      const addSwitchBtn = document.getElementById('addSwitchBtn');
      const downloadSwitchExcelBtn = document.getElementById('downloadSwitchExcelBtn');
      const switchSearchBox = document.getElementById('switchSearchBox');
      
      if (addSwitchBtn && !addSwitchBtn.hasAttribute('data-listener-attached')) {
        addSwitchBtn.addEventListener('click', addNewSwitch);
        addSwitchBtn.setAttribute('data-listener-attached', 'true');
      }
      if (downloadSwitchExcelBtn && !downloadSwitchExcelBtn.hasAttribute('data-listener-attached')) {
        downloadSwitchExcelBtn.addEventListener('click', downloadSwitchExcel);
        downloadSwitchExcelBtn.setAttribute('data-listener-attached', 'true');
      }
      if (switchSearchBox && !switchSearchBox.hasAttribute('data-listener-attached')) {
        switchSearchBox.addEventListener('input', searchSwitchTable);
        switchSearchBox.setAttribute('data-listener-attached', 'true');
      }
    } else if (pageId === 'reports') {
      loadReportsData();
    } else if (pageId === 'settings') {
      loadSettingsData();
    }
  }
}

function updateActiveNavLink(pageId) {
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('data-page') === pageId) {
      link.classList.add('active');
    }
  });
}

// Enhanced Dashboard functionality
function loadDashboardData() {
  fetch('api/dashboard/analytics.php')
    .then(response => response.json())
    .then(data => {
      updateDashboardStats(data);
      createDashboardCharts(data);
      updateRecentActivity(data.recent_activity);
      updateDepartmentSummary(data);
    })
    .catch(error => {
      console.error('Error loading dashboard data:', error);
      showNotification('Error loading dashboard data', 'error');
    });
}

function updateDashboardStats(data) {
  const totals = data.totals;
  
  // Update stat cards
  document.getElementById('totalSystems').textContent = totals.systems || 0;
  document.getElementById('totalPrinters').textContent = totals.printers || 0;
  document.getElementById('totalSwitches').textContent = totals.switches || 0;
  document.getElementById('totalRacks').textContent = totals.racks || 0;
  document.getElementById('totalCameras').textContent = totals.cameras || 0;
  document.getElementById('totalValue').textContent = `₹${(totals.total_value || 0).toLocaleString()}`;
  
  // Update trends
  document.getElementById('systemsTrend').textContent = `${totals.systems} active systems`;
  document.getElementById('printersTrend').textContent = `${totals.printers} devices`;
  document.getElementById('switchesTrend').textContent = `${totals.switches} network devices`;
  document.getElementById('racksTrend').textContent = `${totals.racks} infrastructure units`;
  document.getElementById('camerasTrend').textContent = `${totals.cameras} security devices`;
  document.getElementById('valueTrend').textContent = `Total investment value`;
}

function createDashboardCharts(data) {
  createDepartmentChart(data);
  createAssetTypeChart(data);
  createValueChart(data);
}

function createDepartmentChart(data) {
  const canvas = document.getElementById('departmentChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  
  // Aggregate department data
  const deptData = {};
  const deptSystems = data.by_department;
  
  // Combine all department data
  [...(deptSystems.systems || []), ...(deptSystems.printers || []), 
   ...(deptSystems.switches || []), ...(deptSystems.racks || []),
   ...(deptSystems.cameras || [])].forEach(item => {
    const dept = item.dept || item.building_block;
    if (dept) {
      deptData[dept] = (deptData[dept] || 0) + (parseInt(item.systems || item.printers || item.switches || item.racks || item.cameras || 0));
    }
  });
  
  const departments = Object.keys(deptData);
  const counts = Object.values(deptData);
  const maxCount = Math.max(...counts, 1);
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  if (departments.length === 0) {
    ctx.fillStyle = '#718096';
    ctx.font = '16px Inter';
    ctx.textAlign = 'center';
    ctx.fillText('No data available', canvas.width / 2, canvas.height / 2);
    return;
  }
  
  const colors = ['#3182ce', '#48bb78', '#ed8936', '#9f7aea', '#4299e1', '#f56565'];
  const barWidth = Math.min(60, (canvas.width - 80) / departments.length - 20);
  const spacing = Math.max(80, (canvas.width - 80) / departments.length);
  
  departments.forEach((dept, index) => {
    const barHeight = (counts[index] / maxCount) * (canvas.height - 120);
    const x = 40 + index * spacing + (spacing - barWidth) / 2;
    const y = canvas.height - barHeight - 60;
    
    // Draw bar
    ctx.fillStyle = colors[index % colors.length];
    ctx.fillRect(x, y, barWidth, barHeight);
    
    // Draw department label with proper spacing
    ctx.fillStyle = '#4a5568';
    ctx.font = '14px Inter';
    ctx.textAlign = 'center';
    ctx.save();
    ctx.translate(x + barWidth / 2, canvas.height - 20);
    ctx.rotate(-Math.PI / 6);
    ctx.fillText(dept, 0, 0);
    ctx.restore();
    
    // Draw count label
    ctx.fillStyle = '#1a202c';
    ctx.font = 'bold 16px Inter';
    ctx.textAlign = 'center';
    ctx.fillText(counts[index], x + barWidth / 2, y - 10);
  });
}

function createAssetTypeChart(data) {
  const canvas = document.getElementById('assetTypeChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  const totals = data.totals;
  
  const assetTypes = [
    { name: 'Systems', count: totals.systems, color: '#3182ce' },
    { name: 'Printers', count: totals.printers, color: '#48bb78' },
    { name: 'Switches', count: totals.switches, color: '#ed8936' },
    { name: 'Racks', count: totals.racks, color: '#9f7aea' },
    { name: 'Cameras', count: totals.cameras, color: '#4299e1' }
  ];
  
  const total = assetTypes.reduce((sum, asset) => sum + asset.count, 0);
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  if (total === 0) {
    ctx.fillStyle = '#718096';
    ctx.font = '16px Inter';
    ctx.textAlign = 'center';
    ctx.fillText('No data available', canvas.width / 2, canvas.height / 2);
    return;
  }
  
  const centerX = canvas.width / 2;
  const centerY = canvas.height / 2 - 20;
  const radius = Math.min(centerX, centerY) - 40;
  
  let currentAngle = -Math.PI / 2;
  
  assetTypes.forEach((asset, index) => {
    if (asset.count > 0) {
      const sliceAngle = (asset.count / total) * 2 * Math.PI;
      
      // Draw pie slice
      ctx.beginPath();
      ctx.moveTo(centerX, centerY);
      ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
      ctx.closePath();
      ctx.fillStyle = asset.color;
      ctx.fill();
      
      // Draw label on slice
      const labelAngle = currentAngle + sliceAngle / 2;
      const labelX = centerX + Math.cos(labelAngle) * (radius * 0.7);
      const labelY = centerY + Math.sin(labelAngle) * (radius * 0.7);
      
      ctx.fillStyle = 'white';
      ctx.font = 'bold 14px Inter';
      ctx.textAlign = 'center';
      ctx.fillText(asset.count, labelX, labelY);
      
      currentAngle += sliceAngle;
    }
  });
  
  // Draw legend below pie chart
  const legendY = centerY + radius + 40;
  const legendSpacing = canvas.width / assetTypes.length;
  
  assetTypes.forEach((asset, index) => {
    const legendX = (index + 0.5) * legendSpacing;
    
    // Color box
    ctx.fillStyle = asset.color;
    ctx.fillRect(legendX - 40, legendY, 20, 15);
    
    // Text
    ctx.fillStyle = '#1a202c';
    ctx.font = '12px Inter';
    ctx.textAlign = 'left';
    ctx.fillText(`${asset.name}: ${asset.count}`, legendX - 15, legendY + 12);
  });
}

function createValueChart(data) {
  const canvas = document.getElementById('valueChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  
  // Calculate values by asset type
  const valueData = [
    { name: 'Systems', value: 0, color: '#3182ce' },
    { name: 'Printers', value: 0, color: '#48bb78' },
    { name: 'Switches', value: 0, color: '#ed8936' },
    { name: 'Racks', value: 0, color: '#9f7aea' },
    { name: 'Cameras', value: 0, color: '#4299e1' }
  ];
  
  // Sum values by department for each asset type
  data.by_department.systems?.forEach(item => valueData[0].value += parseFloat(item.system_value || 0));
  data.by_department.printers?.forEach(item => valueData[1].value += parseFloat(item.printer_value || 0));
  data.by_department.switches?.forEach(item => valueData[2].value += parseFloat(item.switch_value || 0));
  data.by_department.racks?.forEach(item => valueData[3].value += parseFloat(item.rack_value || 0));
  data.by_department.cameras?.forEach(item => valueData[4].value += parseFloat(item.camera_value || 0));
  
  const maxValue = Math.max(...valueData.map(item => item.value), 1);
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  const barHeight = 40;
  const spacing = 60;
  const startY = 60;
  const chartWidth = canvas.width - 200;
  
  valueData.forEach((item, index) => {
    const barWidth = (item.value / maxValue) * chartWidth;
    const y = startY + index * spacing;
    
    // Draw bar
    ctx.fillStyle = item.color;
    ctx.fillRect(120, y, barWidth, barHeight);
    
    // Draw label
    ctx.fillStyle = '#1a202c';
    ctx.font = '14px Inter';
    ctx.textAlign = 'right';
    ctx.fillText(item.name, 110, y + barHeight / 2 + 5);
    
    // Draw value
    ctx.fillStyle = '#4a5568';
    ctx.font = '12px Inter';
    ctx.textAlign = 'left';
    ctx.fillText(`₹${item.value.toLocaleString()}`, 130 + barWidth, y + barHeight / 2 + 5);
  });
}

function updateRecentActivity(activities) {
  const activityContainer = document.getElementById('recentActivity');
  if (!activityContainer || !activities) return;
  
  if (activities.length === 0) {
    activityContainer.innerHTML = '<p class="text-center text-gray-500">No recent activity</p>';
    return;
  }
  
  activityContainer.innerHTML = activities.map(activity => `
    <div class="activity-item">
      <div class="activity-icon added">
        <i class="fas fa-${getActivityIcon(activity.type)}"></i>
      </div>
      <div class="activity-details">
        <h4>${activity.type} Added: ${activity.name}</h4>
        <p>${activity.dept} • ${formatDate(activity.date)}</p>
      </div>
    </div>
  `).join('');
}

function updateDepartmentSummary(data) {
  const tbody = document.querySelector('#departmentSummaryTable tbody');
  if (!tbody) return;
  
  // Aggregate data by department
  const deptSummary = {};
  
  // Process each category
  ['systems', 'printers', 'switches', 'racks', 'cameras'].forEach(category => {
    const categoryData = data.by_department[category] || [];
    categoryData.forEach(item => {
      const dept = item.dept || item.building_block;
      if (!deptSummary[dept]) {
        deptSummary[dept] = { 
          systems: 0, printers: 0, switches: 0, racks: 0, cameras: 0, 
          systemValue: 0, printerValue: 0, switchValue: 0, rackValue: 0, cameraValue: 0 
        };
      }
      
      deptSummary[dept][category] = (deptSummary[dept][category] || 0) + parseInt(item[category] || 0);
      deptSummary[dept][category + 'Value'] = (deptSummary[dept][category + 'Value'] || 0) + parseFloat(item[category + '_value'] || 0);
    });
  });
  
  tbody.innerHTML = Object.entries(deptSummary).map(([dept, summary]) => {
    const totalAssets = summary.systems + summary.printers + summary.switches + summary.racks + summary.cameras;
    const totalValue = summary.systemValue + summary.printerValue + summary.switchValue + summary.rackValue + summary.cameraValue;
    
    return `
      <tr>
        <td><strong>${dept}</strong></td>
        <td>${summary.systems}</td>
        <td>${summary.printers}</td>
        <td>${summary.switches}</td>
        <td>${summary.racks}</td>
        <td>${summary.cameras}</td>
        <td><strong>${totalAssets}</strong></td>
        <td><strong>₹${totalValue.toLocaleString()}</strong></td>
      </tr>
    `;
  }).join('');
}

function getActivityIcon(type) {
  const icons = {
    'System': 'desktop',
    'Printer': 'print',
    'Switch': 'network-wired',
    'Rack': 'server',
    'Camera': 'video'
  };
  return icons[type] || 'plus';
}

function formatDate(dateString) {
  if (!dateString || dateString === 'N/A') return 'N/A';
  return new Date(dateString).toLocaleDateString();
}

// Reports functionality
function loadReportsData() {
  fetch('api/system/fetch.php')
    .then(res => res.json())
    .then(data => {
      createReportsCharts(data);
    })
    .catch(err => console.error('Error loading reports data:', err));
}

function createReportsCharts(data) {
  // Department pie chart
  const deptCanvas = document.getElementById('deptPieChart');
  if (deptCanvas) {
    createPieChart(deptCanvas, data, 'dept');
  }
  
  // Cost chart
  const costCanvas = document.getElementById('costChart');
  if (costCanvas) {
    createCostChart(costCanvas, data);
  }
  
  // Timeline chart
  const timelineCanvas = document.getElementById('timelineChart');
  if (timelineCanvas) {
    createTimelineChart(timelineCanvas, data);
  }
}

function createPieChart(canvas, data, field) {
  const ctx = canvas.getContext('2d');
  const counts = {};
  
  data.forEach(item => {
    counts[item[field]] = (counts[item[field]] || 0) + 1;
  });
  
  const labels = Object.keys(counts);
  const values = Object.values(counts);
  const total = values.reduce((sum, val) => sum + val, 0);
  
  let currentAngle = 0;
  labels.forEach((label, index) => {
    const sliceAngle = (values[index] / total) * 2 * Math.PI;
    
    ctx.beginPath();
    ctx.arc(150, 100, 80, currentAngle, currentAngle + sliceAngle);
    ctx.lineTo(150, 100);
    ctx.fillStyle = `hsl(${index * 60}, 70%, 50%)`;
    ctx.fill();
    
    currentAngle += sliceAngle;
  });
}

function createCostChart(canvas, data) {
  const ctx = canvas.getContext('2d');
  const deptCosts = {};
  
  data.forEach(item => {
    const cost = parseFloat(item.cost) || 0;
    deptCosts[item.dept] = (deptCosts[item.dept] || 0) + cost;
  });
  
  const departments = Object.keys(deptCosts);
  const costs = Object.values(deptCosts);
  const maxCost = Math.max(...costs);
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  departments.forEach((dept, index) => {
    const barHeight = (costs[index] / maxCost) * 150;
    const x = index * (canvas.width / departments.length) + 20;
    const y = canvas.height - barHeight - 20;
    
    ctx.fillStyle = `hsl(${index * 60}, 70%, 50%)`;
    ctx.fillRect(x, y, 40, barHeight);
    
    ctx.fillStyle = '#333';
    ctx.font = '12px Inter';
    ctx.textAlign = 'center';
    ctx.fillText(dept, x + 20, canvas.height - 5);
    ctx.fillText(`₹${costs[index].toLocaleString()}`, x + 20, y - 5);
  });
}

function createTimelineChart(canvas, data) {
  const ctx = canvas.getContext('2d');
  const monthlyData = {};
  
  data.forEach(item => {
    if (item.dop) {
      const date = new Date(item.dop);
      const monthKey = `${date.getFullYear()}-${date.getMonth() + 1}`;
      monthlyData[monthKey] = (monthlyData[monthKey] || 0) + 1;
    }
  });
  
  const months = Object.keys(monthlyData).sort();
  const counts = months.map(month => monthlyData[month]);
  const maxCount = Math.max(...counts);
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  months.forEach((month, index) => {
    const barHeight = (counts[index] / maxCount) * 150;
    const x = index * (canvas.width / months.length) + 20;
    const y = canvas.height - barHeight - 20;
    
    ctx.fillStyle = `hsl(${index * 30}, 70%, 50%)`;
    ctx.fillRect(x, y, 30, barHeight);
    
    ctx.fillStyle = '#333';
    ctx.font = '10px Inter';
    ctx.textAlign = 'center';
    ctx.fillText(month.split('-')[1], x + 15, canvas.height - 5);
    ctx.fillText(counts[index], x + 15, y - 5);
  });
}

// Settings functionality
function loadSettingsData() {
  loadDepartments();
  loadAppearanceSettings();
}

function loadDepartments() {
  const deptList = document.getElementById('departmentList');
  if (!deptList) return;
  
  deptList.innerHTML = DEPARTMENTS.map(dept => `
    <div class="department-item">
      <span>${dept}</span>
      <button class="btn-danger" onclick="removeDepartment('${dept}')">Remove</button>
    </div>
  `).join('');
}

function loadAppearanceSettings() {
  const theme = localStorage.getItem('theme') || 'light';
  const language = localStorage.getItem('language') || 'en';
  
  document.getElementById('themeSelect').value = theme;
  document.getElementById('languageSelect').value = language;
}

// Report generation functions
function generateDepartmentReport() {
  showNotification('Department report generated!', 'success');
}

function generateCostReport() {
  showNotification('Cost analysis report generated!', 'success');
}

function generateTimelineReport() {
  showNotification('Timeline report generated!', 'success');
}

function exportAllReports() {
  showNotification('All reports exported successfully!', 'success');
}

function exportPDF() {
  showNotification('PDF report exported!', 'success');
}

function exportCSV() {
  showNotification('CSV data exported!', 'success');
}

function exportExcel() {
  downloadExcel();
}

// Settings functions
function saveDatabaseSettings() {
  const settings = {
    host: document.getElementById('dbHost').value,
    name: document.getElementById('dbName').value,
    user: document.getElementById('dbUser').value,
    pass: document.getElementById('dbPass').value
  };
  localStorage.setItem('dbSettings', JSON.stringify(settings));
  showNotification('Database settings saved!', 'success');
}

function addDepartment() {
  const newDept = document.getElementById('newDept').value.trim();
  if (newDept && !DEPARTMENTS.includes(newDept)) {
    DEPARTMENTS.push(newDept);
    loadDepartments();
    document.getElementById('newDept').value = '';
    showNotification(`Department "${newDept}" added!`, 'success');
  }
}

function removeDepartment(dept) {
  if (confirm(`Remove department "${dept}"?`)) {
    const index = DEPARTMENTS.indexOf(dept);
    if (index > -1) {
      DEPARTMENTS.splice(index, 1);
      loadDepartments();
      showNotification(`Department "${dept}" removed!`, 'success');
    }
  }
}

function saveAppearanceSettings() {
  const theme = document.getElementById('themeSelect').value;
  const language = document.getElementById('languageSelect').value;
  
  localStorage.setItem('theme', theme);
  localStorage.setItem('language', language);
  
  // Apply theme
  document.body.className = theme === 'dark' ? 'dark-theme' : '';
  
  showNotification('Appearance settings saved!', 'success');
}

function saveSecuritySettings() {
  const timeout = document.getElementById('sessionTimeout').value;
  const enable2FA = document.getElementById('enable2FA').checked;
  
  localStorage.setItem('sessionTimeout', timeout);
  localStorage.setItem('enable2FA', enable2FA);
  
  showNotification('Security settings saved!', 'success');
}

// Printer Management Functions
function loadPrinterData() {
  fetch('api/printers/fetch_printers.php')
    .then(res => res.json())
    .then(rows => {
      const tbody = document.querySelector('#printerTable tbody');
      tbody.innerHTML = '';
      rows.forEach((row, index) => {
        const tr = document.createElement('tr');

        // Serial Number
        const snTd = document.createElement('td');
        snTd.textContent = index + 1;
        tr.appendChild(snTd);

        // Add cells for printer data
        PRINTER_FIELDS.forEach(field => {
          const td = document.createElement('td');
          td.textContent = row[field] || '';
          td.dataset.field = field;
          tr.appendChild(td);
        });

        // Actions
        const actionTd = document.createElement('td');
        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit';
        editBtn.onclick = () => enablePrinterEdit(tr, row.id);
        const delBtn = document.createElement('button');
        delBtn.textContent = 'Delete';
        delBtn.onclick = () => deletePrinterRow(row.id);
        actionTd.appendChild(editBtn);
        actionTd.appendChild(delBtn);
        tr.appendChild(actionTd);

        tbody.appendChild(tr);
      });
    })
    .catch(err => {
      console.error('Error loading printer data:', err);
      // If fetch_printers.php doesn't exist, show empty table
      const tbody = document.querySelector('#printerTable tbody');
      tbody.innerHTML = '<tr><td colspan="15" style="text-align: center; padding: 20px; color: #666;">No printer data available. Add printers to get started.</td></tr>';
    });
}

function enablePrinterEdit(tr, id) {
  tr.classList.add('editing');
  [...tr.children].forEach((td, index) => {
    if (index === 0 || index === tr.children.length - 1) return; // Skip S No. and Actions

    const field = td.dataset.field;
    const val = td.textContent;

    if (field === 'dept') {
      // Dropdown for department
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        if (dep === val) opt.selected = true;
        select.appendChild(opt);
      });
      td.innerHTML = '';
      td.appendChild(select);
    } else if (field === 'type') {
      // Dropdown for printer type
      const select = document.createElement('select');
      PRINTER_TYPES.forEach(type => {
        const opt = document.createElement('option');
        opt.value = type;
        opt.textContent = type;
        if (type === val) opt.selected = true;
        select.appendChild(opt);
      });
      td.innerHTML = '';
      td.appendChild(select);
    } else if (field === 'total_printers' || field === 'cost') {
      // Number input for numeric fields
      td.innerHTML = `<input type="number" value="${val}" min="0">`;
    } else if (field === 'dop') {
      // Date input for date of purchase
      td.innerHTML = `<input type="date" value="${val}">`;
    } else {
      td.innerHTML = `<input type="text" value="${val}">`;
    }
  });

  const actionTd = tr.lastChild;
  actionTd.innerHTML = '';
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.onclick = () => savePrinterEdit(tr, id);
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.onclick = loadPrinterData;
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
}

function savePrinterEdit(tr, id) {
  const cells = tr.querySelectorAll('td');
  const data = { id: id };

  // skip S No. (0) and Actions (last)
  let fieldIndex = 0;
  for (let i = 1; i < cells.length - 1; i++) {
    const field = PRINTER_FIELDS[fieldIndex++];
    const input = cells[i].querySelector('input, select');
    data[field] = input.value;
  }

  fetch('api/printers/update_printer.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(() => {
    loadPrinterData();
    showNotification('Printer updated successfully!', 'success');
  }).catch(err => {
    console.error('Error updating printer:', err);
    showNotification('Error updating printer', 'error');
  });
}

function addNewPrinter() {
  const tbody = document.querySelector('#printerTable tbody');
  const tr = document.createElement('tr');

  // S No. cell placeholder
  const snTd = document.createElement('td');
  snTd.textContent = '—';
  tr.appendChild(snTd);

  // Editable cells
  PRINTER_FIELDS.forEach(field => {
    const td = document.createElement('td');
    td.dataset.field = field;
    if (field === 'dept') {
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        select.appendChild(opt);
      });
      td.appendChild(select);
    } else if (field === 'type') {
      const select = document.createElement('select');
      PRINTER_TYPES.forEach(type => {
        const opt = document.createElement('option');
        opt.value = type;
        opt.textContent = type;
        select.appendChild(opt);
      });
      td.appendChild(select);
    } else if (field === 'total_printers' || field === 'cost') {
      td.innerHTML = `<input type="number" value="" min="0">`;
    } else if (field === 'dop') {
      td.innerHTML = `<input type="date" value="">`;
    } else {
      td.innerHTML = `<input type="text" value="">`;
    }
    tr.appendChild(td);
  });

  // Actions
  const actionTd = document.createElement('td');
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.onclick = () => saveNewPrinter(tr);
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.onclick = () => { loadPrinterData(); document.getElementById('addPrinterBtn').disabled = false; };
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
  tr.appendChild(actionTd);

  // Prepend to top
  tbody.insertBefore(tr, tbody.firstChild);
  document.getElementById('addPrinterBtn').disabled = true;
}

function saveNewPrinter(tr) {
  const cells = tr.querySelectorAll('td');
  const data = {};
  // skip S No. (0) and actions (last)
  let fieldIndex = 0;
  for (let i = 1; i < cells.length - 1; i++) {
    const field = PRINTER_FIELDS[fieldIndex++];
    const input = cells[i].querySelector('input, select');
    data[field] = input.value;
  }

  fetch('api/printers/insert_printer.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(() => { 
    loadPrinterData(); 
    document.getElementById('addPrinterBtn').disabled = false;
    showNotification('Printer added successfully!', 'success');
  }).catch(err => {
    console.error('Error adding printer:', err);
    showNotification('Error adding printer', 'error');
    document.getElementById('addPrinterBtn').disabled = false;
  });
}

function deletePrinterRow(id) {
  if (!confirm('Delete this printer record?')) return;
  fetch('api/printers/delete_printer.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  }).then(() => {
    loadPrinterData();
    showNotification('Printer deleted successfully!', 'success');
  }).catch(err => {
    console.error('Error deleting printer:', err);
    showNotification('Error deleting printer', 'error');
  });
}

// Printer search functionality
function searchPrinterTable() {
  const searchTerm = document.getElementById('printerSearchBox').value.toLowerCase();
  const rows = document.querySelectorAll('#printerTable tbody tr');
  
  rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    let found = false;
    
    cells.forEach(cell => {
      if (cell.textContent.toLowerCase().includes(searchTerm)) {
        found = true;
      }
    });
    
    row.style.display = found ? '' : 'none';
  });
}

// Printer Excel download functionality
function downloadPrinterExcel() {
  const downloadBtn = document.getElementById('downloadPrinterExcelBtn');
  const originalText = downloadBtn.textContent;
  downloadBtn.textContent = '⏳ Generating...';
  downloadBtn.disabled = true;
  
  fetch('api/printers/fetch_printers.php')
    .then(res => res.json())
    .then(data => {
      if (!data || data.length === 0) {
        alert('No printer data available to export');
        return;
      }
      
      // Prepare data for Excel
      const excelData = data.map((row, index) => ({
        'S No.': index + 1,
        'Department': row.dept,
        'Lab Name': row.lab_name,
        'Make': row.make,
        'Model': row.model,
        'Type': row.type,
        'Paper Size': row.paper_size,
        'Cartridge Model': row.cartridge_model,
        'Total Printers': row.total_printers,
        'Cost': row.cost,
        'Registration No': row.reg_no,
        'Purchase No': row.p_no,
        'Date of Purchase': row.dop,
        'Remarks': row.remarks
      }));
      
      // Create workbook
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.json_to_sheet(excelData);
      
      // Add worksheet to workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Printer Inventory');
      
      // Generate filename with current date
      const now = new Date();
      const dateStr = now.toISOString().split('T')[0];
      const filename = `Printer_Inventory_${dateStr}.xlsx`;
      
      // Download file
      XLSX.writeFile(wb, filename);
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
      
      // Show success message
      showNotification('Printer Excel file downloaded successfully!', 'success');
    })
    .catch(error => {
      console.error('Error downloading printer Excel:', error);
      alert('Error downloading printer Excel file. Please try again.');
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
    });
}

// Switch Management Functions
const SWITCH_FIELDS = [
  "dept", "lab_name", "make", "model", "serial_number", "poe_type", "access_port",
  "t_ports_count", "t_ports_speed", "sfp_ports_count", "sfp_ports_speed",
  "uplink_sfp_ports_count", "uplink_sfp_ports_speed", "reg_no", "page_no",
  "qty", "price", "dop", "supplier_name", "switch_ip", "remarks"
];

function loadSwitches() {
  fetch('api/switches/fetch_switches.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector('#switchesTable tbody');
      tbody.innerHTML = '';
      
      data.forEach((switchItem, index) => {
        addSwitchRow(switchItem, index + 1);
      });
    })
    .catch(err => {
      console.error('Error loading switches:', err);
      showNotification('Error loading switches', 'error');
    });
}

function addSwitchRow(switchItem, sn) {
  const tbody = document.querySelector('#switchesTable tbody');
  const tr = document.createElement('tr');
  tr.dataset.id = switchItem.id;

  // S.No
  const snTd = document.createElement('td');
  snTd.textContent = sn;
  tr.appendChild(snTd);

  // Data cells
  SWITCH_FIELDS.forEach(field => {
    const td = document.createElement('td');
    td.dataset.field = field;
    td.textContent = switchItem[field] || '';
    tr.appendChild(td);
  });

  // Actions
  const actionTd = document.createElement('td');
  
  const editBtn = document.createElement('button');
  editBtn.textContent = 'Edit';
  editBtn.className = 'action-btn action-edit';
  editBtn.onclick = () => enableSwitchEdit(tr, switchItem.id);
  
  const deleteBtn = document.createElement('button');
  deleteBtn.textContent = 'Delete';
  deleteBtn.className = 'action-btn action-delete';
  deleteBtn.onclick = () => deleteSwitch(switchItem.id);
  
  actionTd.appendChild(editBtn);
  actionTd.appendChild(deleteBtn);
  tr.appendChild(actionTd);

  tbody.appendChild(tr);
}

function addNewSwitch() {
  const tbody = document.querySelector('#switchesTable tbody');
  const tr = document.createElement('tr');

  // S No. cell placeholder
  const snTd = document.createElement('td');
  snTd.textContent = '—';
  tr.appendChild(snTd);

  // Editable cells
  SWITCH_FIELDS.forEach(field => {
    const td = document.createElement('td');
    td.dataset.field = field;
    if (field === 'dept') {
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        select.appendChild(opt);
      });
      // Remove auto-save on change - only save on button click
      td.appendChild(select);
    } else if (field === 'poe_type') {
      const select = document.createElement('select');
      ['PoE', 'Non-PoE'].forEach(type => {
        const opt = document.createElement('option');
        opt.value = type;
        opt.textContent = type;
        if (type === 'Non-PoE') opt.selected = true; // Default to Non-PoE
        select.appendChild(opt);
      });
      // Remove auto-save on change - only save on button click
      td.appendChild(select);
    } else {
      td.textContent = '';
      td.contentEditable = true;
      // Remove auto-save on blur - only save on button click
    }
    tr.appendChild(td);
  });

  // Actions
  const actionTd = document.createElement('td');
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.className = 'action-btn action-save';
  saveBtn.onclick = () => saveNewSwitch(tr);
  
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.className = 'action-btn action-cancel';
  cancelBtn.onclick = () => tr.remove();
  
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
  tr.appendChild(actionTd);

  tbody.insertBefore(tr, tbody.firstChild);
}

function saveNewSwitch(tr) {
  const data = {};
  SWITCH_FIELDS.forEach(field => {
    const cell = tr.querySelector(`[data-field="${field}"]`);
    if (cell) {
      // Handle select elements
      if (cell.tagName === 'SELECT') {
        data[field] = cell.value || '';
      } else {
        // Handle text content
        data[field] = cell.textContent || cell.value || '';
      }
    } else {
      data[field] = '';
    }
  });

  console.log('Sending switch data:', data);
  console.log('PoE type value:', data.poe_type, 'Type:', typeof data.poe_type);
  
  fetch('api/switches/insert_switch.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
  .then(res => {
    console.log('Response status:', res.status);
    return res.json();
  })
  .then(result => {
    console.log('Response data:', result);
    if (result.success) {
      showNotification('Switch added successfully!', 'success');
      loadSwitches();
    } else {
      showNotification('Error adding switch: ' + result.error, 'error');
    }
  })
  .catch(err => {
    console.error('Error adding switch:', err);
    showNotification('Error adding switch: ' + err.message, 'error');
  });
}


function enableSwitchEdit(tr, id) {
  tr.classList.add('editing');
  [...tr.children].forEach((td, index) => {
    if (index === 0 || index === tr.children.length - 1) return; // Skip S No. and Actions

    const field = td.dataset.field;
    const val = td.textContent;

    if (field === 'dept') {
      // Dropdown for department
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        if (dep === val) opt.selected = true;
        select.appendChild(opt);
      });
      td.innerHTML = '';
      td.appendChild(select);
    } else if (field === 'poe_type') {
      // Dropdown for PoE type
      const select = document.createElement('select');
      ['PoE', 'Non-PoE'].forEach(type => {
        const opt = document.createElement('option');
        opt.value = type;
        opt.textContent = type;
        if (type === val) opt.selected = true;
        select.appendChild(opt);
      });
      td.innerHTML = '';
      td.appendChild(select);
    } else {
      // Text input for other fields
      const input = document.createElement('input');
      input.type = 'text';
      input.value = val;
      input.style.width = '100%';
      input.style.padding = '4px';
      input.style.border = '1px solid #ddd';
      input.style.borderRadius = '4px';
      td.innerHTML = '';
      td.appendChild(input);
    }
  });

  // Replace action buttons with Save/Cancel
  const actionTd = tr.children[tr.children.length - 1];
  actionTd.innerHTML = '';
  
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.className = 'action-btn action-save';
  saveBtn.onclick = () => saveSwitchEdit(tr, id);
  
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.className = 'action-btn action-cancel';
  cancelBtn.onclick = () => loadSwitches();
  
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
}

function saveSwitchEdit(tr, id) {
  const cells = tr.querySelectorAll('td');
  const data = { id: id };

  // skip S No. (0) and Actions (last)
  let fieldIndex = 0;
  for (let i = 1; i < cells.length - 1; i++) {
    const field = SWITCH_FIELDS[fieldIndex++];
    const input = cells[i].querySelector('input, select');
    data[field] = input.value;
  }

  fetch('api/switches/update_switch.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(result => {
    if (result.success) {
      showNotification('Switch updated successfully!', 'success');
      loadSwitches();
    } else {
      showNotification('Error updating switch: ' + result.error, 'error');
    }
  })
  .catch(err => {
    console.error('Error updating switch:', err);
    showNotification('Error updating switch', 'error');
  });
}

function deleteSwitch(id) {
  if (!confirm('Are you sure you want to delete this switch?')) return;
  
  fetch('api/switches/delete_switch.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(result => {
    if (result.success) {
      showNotification('Switch deleted successfully!', 'success');
      loadSwitches();
    } else {
      showNotification('Error deleting switch: ' + result.error, 'error');
    }
  })
  .catch(err => {
    console.error('Error deleting switch:', err);
    showNotification('Error deleting switch', 'error');
  });
}

function searchSwitchTable() {
  const searchTerm = document.getElementById('switchSearchBox').value.toLowerCase();
  const rows = document.querySelectorAll('#switchesTable tbody tr');
  
  rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    let found = false;
    
    cells.forEach(cell => {
      if (cell.textContent.toLowerCase().includes(searchTerm)) {
        found = true;
      }
    });
    
    row.style.display = found ? '' : 'none';
  });
}

function downloadSwitchExcel() {
  const downloadBtn = document.getElementById('downloadSwitchExcelBtn');
  const originalText = downloadBtn.textContent;
  downloadBtn.textContent = '⏳ Generating...';
  downloadBtn.disabled = true;
  
  fetch('api/switches/fetch_switches.php')
    .then(res => res.json())
    .then(data => {
      if (!data || data.length === 0) {
        alert('No switch data available to export');
        return;
      }
      
      // Prepare data for Excel
      const excelData = data.map((row, index) => ({
        'S No.': index + 1,
        'Department': row.dept,
        'Laboratory/Location': row.lab_name,
        'Make': row.make,
        'Model': row.model,
        'Serial Number': row.serial_number,
        'PoE/Non-PoE': row.poe_type,
        'Access Port': row.access_port,
        'No. of T Ports': row.t_ports_count,
        'T Ports Speed': row.t_ports_speed,
        'SFP Ports': row.sfp_ports_count,
        'SFP Ports Speed': row.sfp_ports_speed,
        'Uplink SFP Ports': row.uplink_sfp_ports_count,
        'Uplink SFP Ports Speed': row.uplink_sfp_ports_speed,
        'Register Number': row.reg_no,
        'Page Number': row.page_no,
        'QTY': row.qty,
        'Price in Rs.': row.price,
        'Date of Purchase': row.dop,
        'Supplier Name': row.supplier_name,
        'Switch IP': row.switch_ip,
        'Remarks': row.remarks
      }));
      
      // Create workbook
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.json_to_sheet(excelData);
      
      // Add worksheet to workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Switch Inventory');
      
      // Generate filename with current date
      const now = new Date();
      const dateStr = now.toISOString().split('T')[0];
      const filename = `Switch_Inventory_${dateStr}.xlsx`;
      
      // Download file
      XLSX.writeFile(wb, filename);
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
      
      // Show success message
      showNotification('Switch Excel file downloaded successfully!', 'success');
    })
    .catch(error => {
      console.error('Error downloading switch Excel:', error);
      alert('Error downloading switch Excel file. Please try again.');
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
    });
}

const DEPARTMENTS = ["CSE","ECE","IT","ME","CE","EEE"]; // your dropdown options
const FIELDS = [
  "dept","lab_name","make_name","model_name","serial_no",
  "processor","generation","ram_gb","primary_storage","secondary_storage",
  "operating_system","gpu_name","monitor_type","monitor_size","monitor_serial",
  "qty","cost","reg_no","p_no","dop","remarks"
];

// Printer-specific constants
const PRINTER_TYPES = ["Laser", "DMP", "Inkjet", "All in one", "Xerox", "Scanner"];
const PRINTER_FIELDS = [
  "dept", "lab_name", "make", "model", "type", "paper_size", 
  "cartridge_model", "total_printers", "cost", "reg_no", "p_no", "dop", "remarks"
];

// Rack-specific constants & functions
const RACK_FIELDS = ["dept","lab_name","make","rack_size","pdu","reg_no","page_no","price","dop","supplier_name","remarks"];

function loadRacks(){
  fetch('api/racks/fetch_racks.php')
    .then(r=>r.json())
    .then(data=>{
      const tbody=document.querySelector('#racksTable tbody'); if(!tbody) return; tbody.innerHTML='';
      data.forEach((row,i)=>addRackRow(row,i+1));
    })
    .catch(err=>{ console.error('Error loading racks',err); showNotification('Error loading racks','error'); });
}

function addRackRow(row,sn){
  const tbody=document.querySelector('#racksTable tbody');
  const tr=document.createElement('tr'); tr.dataset.id=row.id;
  const snTd=document.createElement('td'); snTd.textContent=sn; tr.appendChild(snTd);
  RACK_FIELDS.forEach(f=>{ const td=document.createElement('td'); td.dataset.field=f; td.textContent=row[f]||''; tr.appendChild(td); });
  const actionTd=document.createElement('td');
  const editBtn=document.createElement('button'); editBtn.textContent='Edit'; editBtn.onclick=()=>enableRackEdit(tr,row.id);
  const delBtn=document.createElement('button'); delBtn.textContent='Delete'; delBtn.onclick=()=>deleteRack(row.id);
  actionTd.appendChild(editBtn); actionTd.appendChild(delBtn); tr.appendChild(actionTd);
  tbody.appendChild(tr);
}

function addNewRack(){
  const tbody=document.querySelector('#racksTable tbody');
  const tr=document.createElement('tr');
  const snTd=document.createElement('td'); snTd.textContent='—'; tr.appendChild(snTd);
  RACK_FIELDS.forEach(field=>{
    const td=document.createElement('td'); td.dataset.field=field;
    if(field==='dept') { const select=document.createElement('select'); DEPARTMENTS.forEach(dep=>{ const opt=document.createElement('option'); opt.value=dep; opt.textContent=dep; select.appendChild(opt); }); td.appendChild(select); }
    else if(field==='dop'){ td.innerHTML='<input type="date">'; }
    else if(['price','page_no'].includes(field)){ td.innerHTML='<input type="number" step="any">'; }
    else { td.innerHTML='<input type="text">'; }
    tr.appendChild(td);
  });
  const actionTd=document.createElement('td');
  const saveBtn=document.createElement('button'); saveBtn.textContent='Save'; saveBtn.onclick=()=>saveNewRack(tr);
  const cancelBtn=document.createElement('button'); cancelBtn.textContent='Cancel'; cancelBtn.onclick=()=>tr.remove();
  actionTd.appendChild(saveBtn); actionTd.appendChild(cancelBtn); tr.appendChild(actionTd);
  tbody.insertBefore(tr, tbody.firstChild);
}

function saveNewRack(tr){
  const data={};
  RACK_FIELDS.forEach(f=>{ const cell=tr.querySelector(`[data-field="${f}"]`); const input=cell.querySelector('input, select'); data[f]= input? input.value : cell.textContent; });
  fetch('api/racks/insert_rack.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)})
    .then(r=>r.json()).then(res=>{ if(res.success){ showNotification('Rack added','success'); loadRacks(); } else { showNotification('Error adding rack: '+res.error,'error'); } })
    .catch(err=>{ console.error(err); showNotification('Error adding rack','error'); });
}

function enableRackEdit(tr,id){
  tr.classList.add('editing');
  [...tr.children].forEach((td,i)=>{ if(i===0 || i===tr.children.length-1) return; const field=td.dataset.field; const val=td.textContent; if(field==='dept'){ const select=document.createElement('select'); DEPARTMENTS.forEach(dep=>{ const opt=document.createElement('option'); opt.value=dep; opt.textContent=dep; if(dep===val) opt.selected=true; select.appendChild(opt); }); td.innerHTML=''; td.appendChild(select);} else if(field==='dop'){ td.innerHTML=`<input type="date" value="${val}">`; } else if(['price','page_no'].includes(field)){ td.innerHTML=`<input type="number" step="any" value="${val}">`; } else { td.innerHTML=`<input type="text" value="${val}">`; }});
  const actionTd=tr.lastChild; actionTd.innerHTML=''; const saveBtn=document.createElement('button'); saveBtn.textContent='Save'; saveBtn.onclick=()=>saveRackEdit(tr,id); const cancelBtn=document.createElement('button'); cancelBtn.textContent='Cancel'; cancelBtn.onclick=loadRacks; actionTd.appendChild(saveBtn); actionTd.appendChild(cancelBtn);
}

function saveRackEdit(tr,id){
  const cells=tr.querySelectorAll('td'); const data={ id };
  let idx=0; for(let i=1;i<cells.length-1;i++){ const field=RACK_FIELDS[idx++]; const input=cells[i].querySelector('input, select'); data[field]= input? input.value : cells[i].textContent; }
  fetch('api/racks/update_rack.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)})
    .then(r=>r.json()).then(res=>{ if(res.success){ showNotification('Rack updated','success'); loadRacks(); } else { showNotification('Error updating rack','error'); } })
    .catch(err=>{ console.error(err); showNotification('Error updating rack','error'); });
}

function deleteRack(id){ if(!confirm('Delete this rack?')) return; fetch('api/racks/delete_rack.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({id})}) .then(r=>r.json()).then(res=>{ if(res.success){ showNotification('Rack deleted','success'); loadRacks(); } else { showNotification('Error deleting rack','error'); } }).catch(err=>{ console.error(err); showNotification('Error deleting rack','error'); }); }

function searchRackTable(){ const term=document.getElementById('rackSearchBox').value.toLowerCase(); document.querySelectorAll('#racksTable tbody tr').forEach(row=>{ let found=false; row.querySelectorAll('td').forEach(td=>{ if(td.textContent.toLowerCase().includes(term)) found=true; }); row.style.display = found? '' : 'none'; }); }

function downloadRackExcel(){ const btn=document.getElementById('downloadRackExcelBtn'); const original=btn.textContent; btn.textContent='⏳ Generating...'; btn.disabled=true; fetch('api/racks/fetch_racks.php').then(r=>r.json()).then(data=>{ if(!data || !data.length){ alert('No rack data to export'); return; } const excelData=data.map((row,i)=>({'S No.':i+1,'Department':row.dept,'Laboratory/Location':row.lab_name,'Make':row.make,'Size':row.rack_size,'Power Distribution Unit':row.pdu,'Register Number':row.reg_no,'Page Number':row.page_no,'Price in Rs.':row.price,'Date of Purchase':row.dop,'Supplier Name':row.supplier_name,'Remarks':row.remarks})); const wb=XLSX.utils.book_new(); const ws=XLSX.utils.json_to_sheet(excelData); XLSX.utils.book_append_sheet(wb, ws, 'Rack Inventory'); const dateStr=new Date().toISOString().split('T')[0]; XLSX.writeFile(wb, `Rack_Inventory_${dateStr}.xlsx`); showNotification('Rack Excel file downloaded successfully!','success'); }).catch(err=>{ console.error(err); alert('Error downloading rack Excel'); }).finally(()=>{ btn.textContent=original; btn.disabled=false; }); }

// Camera Management Functions
const CAMERA_FIELDS = ["building_block","location","make","model","type","pixel","qty","cost","reg_no","p_no","dop","remarks"];
const CAMERA_TYPES = ["IP", "HD", "Analog"];
const CAMERA_PIXELS = ["1.3Mp", "2.0Mp", "3.2Mp", "4.0Mp", "5.0Mp", "6.0Mp", "8.0Mp"];

function loadCameras(){
  fetch('api/cameras/fetch_cameras.php')
    .then(response => response.json())
    .then(data => {
      const tbody = document.querySelector('#camerasTable tbody');
      tbody.innerHTML = '';
      if(data && data.length > 0) {
        data.forEach((camera, index) => {
          addCameraRow(camera, index + 1);
        });
      }
    })
    .catch(error => {
      console.error('Error loading cameras:', error);
      showNotification('Error loading camera data', 'error');
    });
}

function addCameraRow(camera, sn){
  const tbody = document.querySelector('#camerasTable tbody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>${sn}</td>
    <td>${camera.building_block || ''}</td>
    <td>${camera.location || ''}</td>
    <td>${camera.make || ''}</td>
    <td>${camera.model || ''}</td>
    <td>${camera.type || ''}</td>
    <td>${camera.pixel || ''}</td>
    <td>${camera.qty || 0}</td>
    <td>₹${camera.cost ? parseFloat(camera.cost).toLocaleString() : '0'}</td>
    <td>${camera.reg_no || ''}</td>
    <td>${camera.p_no || ''}</td>
    <td>${camera.dop || ''}</td>
    <td>${camera.remarks || ''}</td>
    <td class="actions">
      <button onclick="enableCameraEdit(this.parentElement.parentElement, ${camera.id})" title="Edit">Edit</button>
      <button onclick="deleteCamera(${camera.id})" title="Delete">Delete</button>
    </td>
  `;
  tbody.appendChild(tr);
}

function addNewCamera(){
  const tbody = document.querySelector('#camerasTable tbody');
  const tr = document.createElement('tr');
  tr.classList.add('editing', 'new-row');
  tr.innerHTML = `
    <td>New</td>
    <td><input type="text" placeholder="Building/Block" data-field="building_block"></td>
    <td><input type="text" placeholder="Location" data-field="location"></td>
    <td><input type="text" placeholder="Make" data-field="make"></td>
    <td><input type="text" placeholder="Model" data-field="model"></td>
    <td><select data-field="type">${CAMERA_TYPES.map(t => `<option value="${t}">${t}</option>`).join('')}</select></td>
    <td><select data-field="pixel">${CAMERA_PIXELS.map(p => `<option value="${p}">${p}</option>`).join('')}</select></td>
    <td><input type="number" placeholder="Quantity" data-field="qty" min="1" value="1"></td>
    <td><input type="number" placeholder="Cost" data-field="cost" step="0.01"></td>
    <td><input type="text" placeholder="Register No" data-field="reg_no"></td>
    <td><input type="text" placeholder="P. No" data-field="p_no"></td>
    <td><input type="date" data-field="dop"></td>
    <td><input type="text" placeholder="Remarks" data-field="remarks"></td>
    <td class="actions">
      <button onclick="saveNewCamera(this.parentElement.parentElement)" title="Save">Save</button>
      <button onclick="this.parentElement.parentElement.remove()" title="Cancel">Cancel</button>
    </td>
  `;
  tbody.insertBefore(tr, tbody.firstChild);
}

function saveNewCamera(tr){
  const data = {};
  tr.querySelectorAll('[data-field]').forEach(input => {
    data[input.dataset.field] = input.value;
  });
  
  if(!data.building_block || !data.location || !data.make || !data.type || !data.pixel) {
    alert('Please fill in all required fields (Building/Block, Location, Make, Type, Pixel)');
    return;
  }
  
  fetch('api/cameras/insert_camera.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(result => {
    if(result.success) {
      showNotification('Camera added successfully!', 'success');
      loadCameras();
    } else {
      showNotification('Error adding camera: ' + (result.error || 'Unknown error'), 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showNotification('Error adding camera', 'error');
  });
}

function enableCameraEdit(tr, id){
  if(tr.classList.contains('editing')) return;
  
  const cells = tr.querySelectorAll('td');
  const originalData = {};
  
  // Building/Block
  originalData.building_block = cells[1].textContent;
  cells[1].innerHTML = `<input type="text" value="${originalData.building_block}" data-field="building_block">`;
  
  // Location
  originalData.location = cells[2].textContent;
  cells[2].innerHTML = `<input type="text" value="${originalData.location}" data-field="location">`;
  
  // Make
  originalData.make = cells[3].textContent;
  cells[3].innerHTML = `<input type="text" value="${originalData.make}" data-field="make">`;
  
  // Model
  originalData.model = cells[4].textContent;
  cells[4].innerHTML = `<input type="text" value="${originalData.model}" data-field="model">`;
  
  // Type
  originalData.type = cells[5].textContent;
  cells[5].innerHTML = `<select data-field="type">${CAMERA_TYPES.map(t => `<option value="${t}" ${t === originalData.type ? 'selected' : ''}>${t}</option>`).join('')}</select>`;
  
  // Pixel
  originalData.pixel = cells[6].textContent;
  cells[6].innerHTML = `<select data-field="pixel">${CAMERA_PIXELS.map(p => `<option value="${p}" ${p === originalData.pixel ? 'selected' : ''}>${p}</option>`).join('')}</select>`;
  
  // Quantity
  originalData.qty = cells[7].textContent;
  cells[7].innerHTML = `<input type="number" value="${originalData.qty}" data-field="qty" min="1">`;
  
  // Cost
  originalData.cost = cells[8].textContent.replace('₹', '').replace(/,/g, '');
  cells[8].innerHTML = `<input type="number" value="${originalData.cost}" data-field="cost" step="0.01">`;
  
  // Register No
  originalData.reg_no = cells[9].textContent;
  cells[9].innerHTML = `<input type="text" value="${originalData.reg_no}" data-field="reg_no">`;
  
  // P. No
  originalData.p_no = cells[10].textContent;
  cells[10].innerHTML = `<input type="text" value="${originalData.p_no}" data-field="p_no">`;
  
  // Date of Purchase
  originalData.dop = cells[11].textContent;
  cells[11].innerHTML = `<input type="date" value="${originalData.dop}" data-field="dop">`;
  
  // Remarks
  originalData.remarks = cells[12].textContent;
  cells[12].innerHTML = `<input type="text" value="${originalData.remarks}" data-field="remarks">`;
  
  // Actions
  cells[13].innerHTML = `
    <button onclick="saveCameraEdit(this.parentElement.parentElement, ${id})" title="Save">Save</button>
    <button onclick="loadCameras()" title="Cancel">Cancel</button>
  `;
  
  tr.classList.add('editing');
}

function saveCameraEdit(tr, id){
  const data = {id: id};
  tr.querySelectorAll('[data-field]').forEach(input => {
    data[input.dataset.field] = input.value;
  });
  
  fetch('api/cameras/update_camera.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(result => {
    if(result.success) {
      showNotification('Camera updated successfully!', 'success');
      loadCameras();
    } else {
      showNotification('Error updating camera: ' + (result.error || 'Unknown error'), 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showNotification('Error updating camera', 'error');
  });
}

function deleteCamera(id){
  if(!confirm('Delete this camera?')) return;
  
  fetch('api/cameras/delete_camera.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({id})
  })
  .then(response => response.json())
  .then(result => {
    if(result.success) {
      showNotification('Camera deleted successfully!', 'success');
      loadCameras();
    } else {
      showNotification('Error deleting camera: ' + (result.error || 'Unknown error'), 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showNotification('Error deleting camera', 'error');
  });
}

function searchCameraTable(){
  const term = document.getElementById('cameraSearchBox').value.toLowerCase();
  document.querySelectorAll('#camerasTable tbody tr').forEach(row => {
    let found = false;
    row.querySelectorAll('td').forEach(td => {
      if(td.textContent.toLowerCase().includes(term)) found = true;
    });
    row.style.display = found ? '' : 'none';
  });
}

function downloadCameraExcel(){
  const btn = document.getElementById('downloadCameraExcelBtn');
  const original = btn.textContent;
  btn.textContent = '⏳ Generating...';
  btn.disabled = true;
  
  fetch('api/cameras/fetch_cameras.php')
    .then(response => response.json())
    .then(data => {
      if(!data || !data.length) {
        alert('No camera data to export');
        return;
      }
      
      const excelData = data.map((row, i) => ({
        'S No.': i + 1,
        'Building / Block': row.building_block,
        'Location': row.location,
        'Make': row.make,
        'Model': row.model,
        'Type': row.type,
        'Pixel': row.pixel,
        'QTY': row.qty,
        'Cost': row.cost,
        'Reg No': row.reg_no,
        'P. No': row.p_no,
        'D.O.P': row.dop,
        'Remarks': row.remarks
      }));
      
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.json_to_sheet(excelData);
      XLSX.utils.book_append_sheet(wb, ws, 'Camera Inventory');
      
      const dateStr = new Date().toISOString().split('T')[0];
      XLSX.writeFile(wb, `Camera_Inventory_${dateStr}.xlsx`);
      
      showNotification('Camera Excel file downloaded successfully!', 'success');
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error downloading camera Excel');
    })
    .finally(() => {
      btn.textContent = original;
      btn.disabled = false;
    });
}


function loadData() {
  fetch('api/system/fetch.php')
    .then(res => res.json())
    .then(rows => {
      const tbody = document.querySelector('#inventoryTable tbody');
      tbody.innerHTML = '';
      rows.forEach(row => {
        const tr = document.createElement('tr');

        // Add cells
        for (const key of Object.keys(row)) {
          const td = document.createElement('td');
          td.textContent = row[key];
          td.dataset.field = key;
          tr.appendChild(td);
        }

        // Actions
        const actionTd = document.createElement('td');
        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit';
        editBtn.onclick = () => enableEdit(tr, row.id);
        const delBtn = document.createElement('button');
        delBtn.textContent = 'Delete';
        delBtn.onclick = () => deleteRow(row.id);
        actionTd.appendChild(editBtn);
        actionTd.appendChild(delBtn);
        tr.appendChild(actionTd);

        tbody.appendChild(tr);
      });
    });
}

function enableEdit(tr, id) {
  tr.classList.add('editing');
  [...tr.children].forEach((td, index) => {
    if (index === 0 || index === tr.children.length - 1) return;

    const field = td.dataset.field;
    const val = td.textContent;

    if (field === 'dept') {
      // Dropdown for department
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        if (dep === val) opt.selected = true;
        select.appendChild(opt);
      });
      td.innerHTML = '';
      td.appendChild(select);
    } else {
      td.innerHTML = `<input type="text" value="${val}">`;
    }
  });

  const actionTd = tr.lastChild;
  actionTd.innerHTML = '';
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.onclick = () => saveEdit(tr, id);
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.onclick = loadData;
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
}

function saveEdit(tr, id) {
  const cells = tr.querySelectorAll('td');
  const data = { id: id };

  // skip ID cell (0) and Actions cell (last)
  let fieldIndex = 0;
  for (let i = 1; i < cells.length - 1; i++) {
    const field = FIELDS[fieldIndex++];
    const input = cells[i].querySelector('input, select');
    data[field] = input.value;
  }

  fetch('api/system/update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(() => loadData());
}

function addNew() {
  const tbody = document.querySelector('#inventoryTable tbody');
  const tr = document.createElement('tr');

  // ID cell placeholder
  const idTd = document.createElement('td');
  idTd.textContent = '—';
  tr.appendChild(idTd);

  // Editable cells
  FIELDS.forEach(field => {
    const td = document.createElement('td');
    td.dataset.field = field;
    if (field === 'dept') {
      const select = document.createElement('select');
      DEPARTMENTS.forEach(dep => {
        const opt = document.createElement('option');
        opt.value = dep;
        opt.textContent = dep;
        select.appendChild(opt);
      });
      td.appendChild(select);
    } else {
      td.innerHTML = `<input type="text" value="">`;
    }
    tr.appendChild(td);
  });

  // Actions
  const actionTd = document.createElement('td');
  const saveBtn = document.createElement('button');
  saveBtn.textContent = 'Save';
  saveBtn.onclick = () => saveNew(tr);
  const cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.onclick = () => { loadData(); document.getElementById('addNewBtn').disabled = false; };
  actionTd.appendChild(saveBtn);
  actionTd.appendChild(cancelBtn);
  tr.appendChild(actionTd);

  // Prepend to top
  tbody.insertBefore(tr, tbody.firstChild);
  document.getElementById('addNewBtn').disabled = true;
}

function saveNew(tr) {
  const cells = tr.querySelectorAll('td');
  const data = {};
  // skip id (0) and actions (last)
  let fieldIndex = 0;
  for (let i = 1; i < cells.length - 1; i++) {
    const field = FIELDS[fieldIndex++];
    const input = cells[i].querySelector('input, select');
    data[field] = input.value;
  }

  fetch('api/system/insert.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(() => { loadData(); document.getElementById('addNewBtn').disabled = false; });
}

function deleteRow(id) {
  if (!confirm('Delete this record?')) return;
  fetch('api/system/delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  }).then(() => loadData());
}

// Search functionality
function searchTable() {
  const searchTerm = document.getElementById('searchBox').value.toLowerCase();
  const rows = document.querySelectorAll('#inventoryTable tbody tr');
  
  rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    let found = false;
    
    cells.forEach(cell => {
      if (cell.textContent.toLowerCase().includes(searchTerm)) {
        found = true;
      }
    });
    
    row.style.display = found ? '' : 'none';
  });
}

// Excel download functionality
function downloadExcel() {
  // Show loading state
  const downloadBtn = document.getElementById('downloadExcelBtn');
  const originalText = downloadBtn.textContent;
  downloadBtn.textContent = '⏳ Generating...';
  downloadBtn.disabled = true;
  
  // Fetch data from server
  fetch('api/system/fetch.php')
    .then(res => res.json())
    .then(data => {
      if (!data || data.length === 0) {
        alert('No data available to export');
        return;
      }
      
      // Prepare data for Excel
      const excelData = data.map(row => ({
        'ID': row.id,
        'Department': row.dept,
        'Lab Name': row.lab_name,
        'Make': row.make_name,
        'Model': row.model_name,
        'Serial No': row.serial_no,
        'Processor': row.processor,
        'Generation': row.generation,
        'RAM (GB)': row.ram_gb,
        'Primary Storage': row.primary_storage,
        'Secondary Storage': row.secondary_storage,
        'Operating System': row.operating_system,
        'GPU': row.gpu_name,
        'Monitor Type': row.monitor_type,
        'Monitor Size': row.monitor_size,
        'Monitor Serial': row.monitor_serial,
        'Quantity': row.qty,
        'Cost': row.cost,
        'Registration No': row.reg_no,
        'Purchase No': row.p_no,
        'Date of Purchase': row.dop,
        'Remarks': row.remarks
      }));
      
      // Create workbook
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.json_to_sheet(excelData);
      
      // Set column widths
      const colWidths = [
        { wch: 8 },   // ID
        { wch: 12 },  // Department
        { wch: 15 },  // Lab Name
        { wch: 12 },  // Make
        { wch: 15 },  // Model
        { wch: 15 },  // Serial No
        { wch: 12 },  // Processor
        { wch: 10 },  // Generation
        { wch: 10 },  // RAM
        { wch: 15 },  // Primary Storage
        { wch: 15 },  // Secondary Storage
        { wch: 15 },  // OS
        { wch: 12 },  // GPU
        { wch: 12 },  // Monitor Type
        { wch: 12 },  // Monitor Size
        { wch: 15 },  // Monitor Serial
        { wch: 8 },   // Quantity
        { wch: 10 },  // Cost
        { wch: 12 },  // Reg No
        { wch: 12 },  // Purchase No
        { wch: 15 },  // DOP
        { wch: 20 }   // Remarks
      ];
      ws['!cols'] = colWidths;
      
      // Add worksheet to workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Lab Inventory');
      
      // Generate filename with current date
      const now = new Date();
      const dateStr = now.toISOString().split('T')[0];
      const filename = `Lab_Inventory_${dateStr}.xlsx`;
      
      // Download file
      XLSX.writeFile(wb, filename);
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
      
      // Show success message
      showNotification('Excel file downloaded successfully!', 'success');
    })
    .catch(error => {
      console.error('Error downloading Excel:', error);
      alert('Error downloading Excel file. Please try again.');
      
      // Reset button state
      downloadBtn.textContent = originalText;
      downloadBtn.disabled = false;
    });
}

// Notification system
function showNotification(message, type = 'info') {
  const notification = document.createElement('div');
  notification.className = `notification notification-${type}`;
  notification.textContent = message;
  
  // Add styles
  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    z-index: 1000;
    animation: slideIn 0.3s ease;
    max-width: 300px;
  `;
  
  // Set background color based on type
  if (type === 'success') {
    notification.style.backgroundColor = '#48bb78';
  } else if (type === 'error') {
    notification.style.backgroundColor = '#f56565';
  } else {
    notification.style.backgroundColor = '#4299e1';
  }
  
  document.body.appendChild(notification);
  
  // Remove after 3 seconds
  setTimeout(() => {
    notification.style.animation = 'slideOut 0.3s ease';
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
  // Initialize navigation
  initNavigation();
  
  // Initialize dashboard
  loadDashboardData();
  
  // Initialize inventory functionality
  loadData();
  document.getElementById('addNewBtn').addEventListener('click', addNew);
  document.getElementById('downloadExcelBtn').addEventListener('click', downloadExcel);
  document.getElementById('searchBox').addEventListener('input', searchTable);
  
  // Initialize printer functionality
  loadPrinterData();
  document.getElementById('addPrinterBtn').addEventListener('click', addNewPrinter);
  document.getElementById('downloadPrinterExcelBtn').addEventListener('click', downloadPrinterExcel);
  document.getElementById('printerSearchBox').addEventListener('input', searchPrinterTable);

  // Initialize switch functionality
  loadSwitches();
  document.getElementById('addSwitchBtn').addEventListener('click', addNewSwitch);
  document.getElementById('downloadSwitchExcelBtn').addEventListener('click', downloadSwitchExcel);
  document.getElementById('switchSearchBox').addEventListener('input', searchSwitchTable);

  // Initialize rack functionality
  if(document.getElementById('racksTable')) {
    loadRacks();
    document.getElementById('addRackBtn').addEventListener('click', addNewRack);
    document.getElementById('downloadRackExcelBtn').addEventListener('click', downloadRackExcel);
    document.getElementById('rackSearchBox').addEventListener('input', searchRackTable);
  }

  // Initialize camera functionality
  if(document.getElementById('camerasTable')) {
    loadCameras();
    document.getElementById('addCameraBtn').addEventListener('click', addNewCamera);
    document.getElementById('downloadCameraExcelBtn').addEventListener('click', downloadCameraExcel);
    document.getElementById('cameraSearchBox').addEventListener('input', searchCameraTable);
  }
});
</script>
</body>
</html>
