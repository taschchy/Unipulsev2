<?php
session_start();

// If user is not logged in, return to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: loginRelated/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>UNIPULSE — Student Wellness Hub</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg-app: #f4f5f6;
    --bg-card: #ffffff;
    --bg-accent: #f8f9fa;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;
    --border-color: #e2e8f0;

    --purple-light: #f5f3ff;
    --purple-main: #7c3aed;
    --purple-dark: #5b21b6;

    --teal-light: #f0fdf4;
    --teal-main: #16a34a;
    --teal-dark: #166534;

    --blue-light: #eff6ff;
    --blue-main: #2563eb;
    --blue-dark: #1e40af;

    --amber-light: #fffbeb;
    --amber-main: #d97706;
    --amber-dark: #92400e;

    --red-light: #fef2f2;
    --red-main: #dc2626;
    --red-dark: #991b1b;

    --radius-sm: 6px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
  }

  @media (prefers-color-scheme: light) {
    :root {
      --bg-app: #fdfdfd;
      --bg-card: #ffffff;
      --bg-accent: #f0f4f8;
      --text-primary: #1e293b;
      --text-secondary: #475569;
      --text-muted: #64748b;
      --border-color: #e2e8f0;

      --purple-light: #ede9fe;
      --purple-main: #c4b5fd;
      --blue-light: #e0f2fe;
      --blue-main: #93c5fd;
      --teal-light: #d1fae5;
      --teal-main: #6ee7b7;
      --amber-light: #fef3c7;
      --amber-main: #fcd34d;
      --red-light: #fee2e2;
      --red-main: #fca5a5;
    }
  }

  body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-app);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 2rem;
    line-height: 1.5;
  }
  .wordmark,
  h2,
  .rc-title {
    font-family: 'Fredoka', sans-serif;
    font-size: 15px;
    font-weight: 600;
  }

  /* ── Header Area ── */
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
  }
  .wordmark {
    font-family: 'Fredoka', sans-serif;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 1px;
    color: var(--text-muted);
  }
  .wordmark b { color: var(--purple-main); }
  .hright { display: flex; align-items: center; gap: 12px; }
  .date-pill {
    font-size: 13px;
    font-weight: 500;
    color: #f82f94;
    border: 1px solid var(--border-color);
    border-radius: 30px;
    padding: 6px 16px;
    background: #c5e987;
    display: flex; align-items: center; gap: 6px;
    shadow: var(--shadow);
  }
  .notif-btn {
    width: 36px; height: 36px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    background: #c5e987;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #f82f94;
    transition: all 0.2s;
  }
  .notif-btn:hover { background: var(--bg-accent); border-color: var(--text-muted); }

  /* ── Application Structure Shell ── */
  .body-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--bg-card);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
  }

  /* ── Side Navigation Panel ── */
  .sidenav {
    border-right: 1px solid var(--border-color);
    padding: 24px 0;
    background: var(--bg-card);
  }
  .nav-profile {
    padding: 0 24px 20px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 16px;
  }
  .av {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--purple-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 600; color: var(--purple-main);
    margin-bottom: 10px;
  }
  .nav-name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
  .nav-sub { font-size: 12px; color: var(--text-secondary); }

  .nav-sec-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
    letter-spacing: 1px;
    padding: 16px 24px 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 16px;
    margin: 4px 12px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
  }
  .nav-item:hover { background: var(--bg-accent); color: var(--text-primary); }
  .nav-item.active { background: var(--purple-light); color: var(--purple-main); font-weight: 600; }
  .nav-item i { font-size: 18px; }
  .nav-badge {
    margin-left: auto;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
  }
  .nav-badge.red { background: var(--red-light); color: var(--red-main); }

  /* ── Core Metric Strip ── */
  .main { background: var(--bg-card); display: flex; flex-direction: column; }
  .stat-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-accent);
  }
  .stat {
    padding: 20px 24px;
    border-right: 1px solid var(--border-color);
  }
  .stat:last-child { border-right: none; }
  .stat-lbl { font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
  .stat-num { font-size: 24px; font-weight: 700; color: var(--text-primary); }
  .stat-note { font-size: 12px; font-weight: 500; margin-top: 4px; }
  .stat-note.green { color: var(--teal-main); }
  .stat-note.red { color: var(--red-main); }

  /* ── Two-Column Layout Workspace ── */
  .main-body { display: grid; grid-template-columns: 1fr 300px; min-height: 500px; }

  /* ── Student Activity Timeline ── */
  .timeline-area {
    border-right: 1px solid var(--border-color);
    padding: 24px;
  }
  .tl-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
  }
  .tl-title {
    font-family: 'Fredoka', sans-serif;
    font-size: 17px;
    font-weight: 600;
    color: var(--text-primary);
  }
  .tl-days { display: flex; gap: 6px; }
  .tl-day {
    font-family: 'Poppins', sans-serif;
    font-size: 12px; font-weight: 500; padding: 5px 12px; border-radius: 30px;
    border: 1px solid var(--border-color); color: var(--text-secondary);
    cursor: pointer; background: var(--bg-card); transition: all 0.2s;
  }
  .tl-day:hover { background: var(--bg-accent); color: var(--text-primary); }
  .tl-day.active {
    background: var(--purple-light);
    border-color: var(--purple-main);
    color: var(--purple-main);
    font-weight: 600;
  }

  .timeline { display: flex; flex-direction: column; gap: 12px; }
  .tl-hour { display: flex; align-items: flex-start; gap: 16px; }
  .tl-time {
    font-size: 11px; font-weight: 600; color: var(--text-muted);
    width: 45px; padding-top: 10px; text-align: right; text-transform: uppercase;
  }
  .tl-slot { flex: 1; }
  .tl-block {
    border-radius: var(--radius-md);
    padding: 12px 16px;
    box-shadow: inset 3px 0 0 0 transparent;
  }
  .tl-block.class {
    background: var(--purple-light); color: var(--purple-dark);
    box-shadow: inset 4px 0 0 0 var(--purple-main);
  }
  .tl-block.study {
    background: var(--amber-light); color: var(--amber-dark);
    box-shadow: inset 4px 0 0 0 var(--amber-main);
  }
  .tl-block.free {
    background: var(--bg-card); color: var(--text-secondary);
    border: 1px dashed var(--border-color);
  }
  .tl-block.test {
    background: var(--red-light); color: var(--red-dark);
    box-shadow: inset 4px 0 0 0 var(--red-main);
  }
  .tl-block.break {
    background: var(--teal-light); color: var(--teal-dark);
    box-shadow: inset 4px 0 0 0 var(--teal-main);
  }
  .tl-block-name { font-weight: 600; font-size: 13px; }
  .tl-block-sub { font-size: 11px; opacity: 0.8; margin-top: 2px; }

  /* ── Sidebar Right Column Widgets ── */
  .right-col { padding: 24px; display: flex; flex-direction: column; gap: 24px; background: #fafafa; }
  @media (prefers-color-scheme: dark) { .right-col { background: #151d30; } }

  .widget-section {
    background: var(--bg-card);
    padding: 16px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow);
  }
  .rc-title {
    font-size: 13px; font-weight: 600; color: var(--text-primary);
    margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .rc-title span { font-size: 11px; font-weight: 500; color: var(--text-muted); text-transform: none; }

  /* Mood Tracker Chips */
  .mood-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px; }
  .mood-chip {
    font-size: 12px; font-weight: 500; padding: 6px 12px; border-radius: 30px;
    border: 1px solid var(--border-color); color: var(--text-secondary);
    cursor: pointer; background: var(--bg-accent); transition: all 0.2s;
  }
  .mood-chip:hover, .mood-chip.sel {
    background: var(--purple-light); border-color: var(--purple-main); color: var(--purple-main);
  }
  /* Visual chips (Daily Mood Check-In) */
  .mood-chips-visual {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 20px;
  }
  .mood-chip-visual {
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    transition: all 0.3s ease;
  }
  .mood-chip-visual:hover {
    background: var(--blue-light);
    border-color: var(--blue-main);
    transform: scale(1.05);
    cursor: pointer;
  }


  /* Task Elements */
  .task-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 0; border-bottom: 1px solid var(--border-color);
  }
  .task-row:last-of-type { border-bottom: none; }
  .tname { font-size: 13px; font-weight: 500; color: var(--text-primary); }
  .ttag { font-size: 11px; font-weight: 500; padding: 2px 8px; border-radius: 20px; }
  .ttag.red { background: var(--red-light); color: var(--red-main); }
  .ttag.amber { background: var(--amber-light); color: var(--amber-main); }
  .ttag.green { background: var(--green-light); color: var(--teal-main); }
  .ttag.purple { background: var(--purple-light); color: var(--purple-dark); }
  .ttag.free { background: var(--bg-accent); color: var(--text-secondary); }

  /* Action buttons for lists */
  .action-btn-group { display: flex; gap: 6px; }
  .action-icon-btn {
    background: none; border: none; cursor: pointer; padding: 4px;
    border-radius: 4px; color: var(--text-secondary); transition: all 0.2s;
  }
  .action-icon-btn:hover { background: var(--bg-accent); color: var(--text-primary); }
  .action-icon-btn.delete:hover { color: var(--red-main); background: var(--red-light); }

  /* Smart Metrics Display Bars */
  .well-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; }
  .well-label { font-size: 12px; font-weight: 600; color: var(--text-secondary); width: 54px; }
  .well-btn {
    background: var(--bg-accent); border: 1px solid var(--border-color);
    color: var(--text-primary); padding: 2px 8px; border-radius: 4px;
    cursor: pointer; font-weight: 700; font-size: 12px; transition: all 0.2s;
  }
  .well-btn:hover { background: var(--border-color); }
  .well-bar { flex: 1; height: 8px; background: var(--bg-accent); border-radius: 4px; overflow: hidden; }
  .well-fill { height: 100%; border-radius: 4px; transition: width 0.3s ease; }
  .well-val { font-size: 12px; font-weight: 600; color: var(--text-primary); width: 55px; text-align: right; }

  /* ── SRS Intelligent UI Containers ── */
  .srs-recommendation-box {
    background: var(--blue-light); border-left: 4px solid var(--blue-main);
    padding: 12px; border-radius: 0 var(--radius-md) var(--radius-md) 0;
    font-size: 12px; font-weight: 500; margin-top: 16px; color: var(--blue-dark);
  }
  .srs-cbt-container {
    background: var(--purple-light); padding: 12px;
    border-radius: var(--radius-md); font-size: 12px;
    font-weight: 500; color: var(--purple-dark); margin-top: 10px;
  }
  .srs-alert-banner {
    background: var(--red-light); color: var(--red-dark);
    border: 1px solid var(--red-main); padding: 10px 14px;
    border-radius: var(--radius-md); font-size: 12px; font-weight: 500;
    margin-bottom: 16px; display: none; align-items: center; gap: 8px;
  }
  .page-view { animation: fadeIn 0.25s ease-in-out; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
  .page-mood {
    background-image: url('https://media.giphy.com/media/dU97uV3UyP0ly/giphy.gif');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    min-height: 100vh; /* Supaya background ni penuhi satu skrin penuh */
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    }
    /* Weather + Spotify layout */
.top-section{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:30px;
}
.weather{
    flex:1;
}
.mood-right-col{
    width:340px;
    flex-shrink:0;
}
.mood-widget-section{
    background:#c4d0df;
    border-radius:0;
    padding:15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}
.rc-title{
    font-size:16px;
    font-weight:600;
    margin-bottom:12px;
}
#songFrame{
    width:100%;
    border:none;
    border-radius:12px;
}
</style>
</head>
<body>

<div class="header">
  <div class="wordmark">UNI<b>PULSE</b></div>
  <div class="hright">
    <span class="date-pill">
    <i class="ti ti-calendar"></i>
    <span id="currentDate"></span>
    </span>
    <button class="notif-btn" aria-label="Notifications" onclick="alert('All university module updates and alert networks are functional.')">
      <i class="ti ti-bell"></i>
    </button>
  </div>
</div>

<div class="body-grid">

  <nav class="sidenav">
    <div class="nav-profile">
      <div class="av">
    <?php
    $name = $_SESSION['full_name'] ?? "Student";
    $parts = explode(" ", $name);
    $initials = "";

foreach ($parts as $p) {
    $initials .= strtoupper(substr($p,0,1));
}

echo substr($initials,0,2);
?>
</div>
      <div class="nav-name">Loading...</div>
      <div class="nav-sub">---</div>
    </div>

    <span class="nav-sec-label">STUDENT DASHBOARD</span>
    <div class="nav-item active" data-target="page-dashboard"><i class="ti ti-layout-dashboard"></i> Overview Hub</div>
    <div class="nav-item" data-target="page-schedule"><i class="ti ti-calendar-event"></i> Lecture Schedule</div>
    <div class="nav-item" data-target="page-tasks"><i class="ti ti-checkbox"></i> Course Tasks <span class="nav-badge red">0</span></div>

    <span class="nav-sec-label">ANALYTICS & WELLBEING</span>
    <div class="nav-item" data-target="page-mood"><i class="ti ti-mood-smile"></i> Mood & Wellness</div>
    <div class="nav-item" data-target="page-mood"><i class="ti ti-chart-bar"></i> Personal Trends</div>
  </nav>

  <main class="main">
    <div class="stat-strip">
      <div class="stat">
        <div class="stat-lbl">Study Buffer Remaining</div>
        <div class="stat-num" id="stat-free-time">0h</div>
        <div class="stat-note green">Optimal Window</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Active Assignments</div>
        <div class="stat-num" id="stat-tasks-due">0</div>
        <div class="stat-note red">Action Required</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Critical Deadline</div>
        <div class="stat-num" style="font-size:14px; padding-top:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" id="stat-next-deadline">None</div>
        <div class="stat-note red">Pending Submission</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Balanced Health Index</div>
        <div class="stat-num" id="stat-wellness-score">--%</div>
        <div class="stat-note">Live Analysis</div>
      </div>
    </div>

    <div id="page-dashboard" class="page-view">
      <div class="main-body">
        <div class="timeline-area">
          <div id="srs-alert-panel" class="srs-alert-banner">
            <i class="ti ti-alert-triangle" style="font-size:16px;"></i>
            <span><strong>High Burnout Risk Threshold Met:</strong> Take a break or connect with support lines: 1-800-UNIPULSE.</span>
          </div>

          <div class="tl-header">
            <span class="tl-title">Academic & Routine Timeline</span>
            <div class="tl-days">
              <button class="tl-day">Mon</button>
              <button class="tl-day">Tue</button>
              <button class="tl-day active">Wed</button>
              <button class="tl-day">Thu</button>
              <button class="tl-day">Fri</button>
            </div>
          </div>
          <div class="timeline" id="timeline-container"></div>

          <div id="srs-recommendation-panel" class="srs-recommendation-box">
            <strong><i class="ti ti-cpu"></i> Automated Routine Recommendation:</strong>
            <span id="srs-rec-text">Evaluating academic slots...</span>
          </div>
        </div>

        <div class="right-col">
          <!-- Quote of the Day -->
          <div class="widget-section">
            <div class="rc-title">
            🌟 Quote of the Day
            </div>
            <p id="dailyQuote" class="quote-text"></p>
          </div>

          <div class="widget-section">
            <div class="rc-title">Course Workload <span>Active</span></div>
            <div id="tasks-container"></div>
          </div>

          <div class="widget-section">
            <div class="rc-title">Completed Task History <span>Archive</span></div>
            <div id="tasks-history-container" style="max-height: 150px; overflow-y: auto;"></div>
          </div>

          <div class="widget-section">
            <div class="rc-title">Bio-Metrics <span>Sync Status</span></div>

            <!-- Sleep Profile -->
            <div class="well-row">
              <span class="well-label">Sleep</span>
              <div style="width:24px;"></div>
              <div class="well-bar"><div class="well-fill" style="width:75%; background:var(--purple-main);"></div></div>
              <div style="width:24px;"></div>
              <span class="well-val">6.5h</span>
            </div>

            <!-- Steps Activity Tracker -->
            <div class="well-row">
              <span class="well-label">Sleep</span>
              <div style="width:24px;"></div>
              <div class="well-bar"><div id="fit-step-bar" class="well-fill" style="width:0%; background:var(--blue-main);"></div></div>
              <div style="width:24px;"></div>
              <span id="fit-step-val" class="well-val">0</span>
            </div>

            <!-- Hydration Input Manager -->
            <div class="well-row">
              <span class="well-label">Water</span>
              <button class="well-btn" onclick="updateMetric('water', -0.25)">-</button>
              <div class="well-bar"><div id="water-bar-fill" class="well-fill" style="width:0%; background:var(--teal-main);"></div></div>
              <button class="well-btn" onclick="updateMetric('water', 0.25)">+</button>
              <span id="water-val" class="well-val">0.00L</span>
            </div>

            <!-- Dietary Meals Tracker -->
            <div class="well-row">
              <span class="well-label">Meals</span>
              <button class="well-btn" onclick="updateMetric('meals', -1)">-</button>
              <div class="well-bar"><div id="meals-bar-fill" class="well-fill" style="width:0%; background:var(--purple-main);"></div></div>
              <button class="well-btn" onclick="updateMetric('meals', 1)">+</button>
              <span id="meals-val" class="well-val">0/3</span>
            </div>

            <!-- Nutritional Calorie Counter -->
            <div class="well-row">
              <span class="well-label">Calories</span>
              <div style="width:24px;"></div>
              <div class="well-bar"><div id="nutrition-calorie-bar" class="well-fill" style="width:0%; background:var(--amber-main);"></div></div>
              <div style="width:24px;"></div>
              <span id="nutrition-calorie-val" class="well-val">0kcal</span>
            </div>
          </div>
        </div>
        </div>
    </div>

    <!-- Supplementary Screens (Dynamic Navigation Compatible) -->
    <div id="page-schedule" class="page-view" style="display: none; padding: 24px;">
      <h2 style="font-size: 18px; font-weight:600; margin-bottom: 8px;">Academic Calendar Integration</h2>
      <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Synchronized live via integrated institute syllabus schedules.</p>

      <!-- Integrated Schedule Entry System -->
      <div style="margin-bottom: 20px; background: var(--bg-accent); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
        <h3 id="schedule-form-title" style="font-size: 14px; margin-bottom: 12px; font-weight: 600;">Add New Schedule Block</h3>
        <form id="add-schedule-form" onsubmit="event.preventDefault(); addNewScheduleSlot();" style="display: flex; gap: 10px; flex-wrap: wrap;">
          <input type="text" id="sched-time" placeholder="e.g., 05:00 PM" required style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px;">
          <input type="text" id="sched-name" placeholder="Class / Routine Name" required style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px; flex: 1; min-width: 150px;">
          <input type="text" id="sched-sub" placeholder="Sub-details / Location" style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px; flex: 1; min-width: 150px;">
          <select id="sched-type" style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px; background: #fff;">
            <option value="class">Class</option>
            <option value="study">Study Focus</option>
            <option value="break">Break / Recess</option>
            <option value="test">Assessment</option>
            <option value="free">Free Slot</option>
          </select>
          <button type="submit" id="sched-submit-btn" style="background: var(--purple-main); color: var(--text-primary); border: none; padding: 6px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 700; cursor: pointer;">Add to Calendar</button>
          <button type="button" id="sched-cancel-btn" onclick="clearScheduleForm()" style="display: none; background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 6px 12px; border-radius: var(--radius-sm); font-size: 13px; cursor: pointer;">Cancel</button>
        </form>
      </div>
      <div id="schedule-list-view" style="display: flex; flex-direction: column; gap: 10px;"></div>
    </div>

    <div id="page-tasks" class="page-view" style="display: none; padding: 24px;">
      <h2 style="font-size: 18px; font-weight:600; margin-bottom: 8px;">Comprehensive Assignment Grid</h2>
      <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Prioritize upcoming exam benchmarks, test profiles, and papers.</p>

      <!-- Integrated Task entry System -->
      <div style="margin-bottom: 20px; background: var(--bg-accent); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
        <h3 id="task-form-title" style="font-size: 14px; margin-bottom: 12px; font-weight: 600;">Create Course Assignment / Task</h3>
        <form id="add-task-form" onsubmit="event.preventDefault(); addNewCourseTask();" style="display: flex; gap: 10px; flex-wrap: wrap;">
          <input type="text" id="task-name-input" placeholder="Task Designation Name" required style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px; flex: 1; min-width: 200px;">
          <input type="text" id="task-tag-input" placeholder="Priority Tag (e.g., Urgent · 3 days)" required style="padding: 6px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-size: 13px;">
          <button type="submit" id="task-submit-btn" style="background: var(--purple-main); color: var(--text-primary); border: none; padding: 6px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 700; cursor: pointer;">Append Task</button>
          <button type="button" id="task-cancel-btn" onclick="clearTaskForm()" style="display: none; background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 6px 12px; border-radius: var(--radius-sm); font-size: 13px; cursor: pointer;">Cancel</button>
        </form>
      </div>
      <div id="tasks-list-view" style="display: flex; flex-direction: column; gap: 10px;"></div>
    </div>

    <div id="page-mood" class="page-view" style="display:none; padding:24px;">
      <h2 style="font-size:18px; font-weight:600; margin-bottom:8px;">Daily Mood Check-In & Wellness</h2>
      <p style="font-size:13px; color:var(--text-secondary); margin-bottom:20px;">Update your current mood and wellbeing status.</p>
      <div class="top-section">
    <!-- Weather -->
    <div class="weather">
        <a class="weatherwidget-io"
           href="https://forecast7.com/en/4d21101d98/malaysia/"
           data-label_1="MALAYSIA"
           data-label_2="WEATHER"
           data-theme="mountains">
           MALAYSIA WEATHER
        </a>
    </div>
    <!-- Right Column -->
    <div class="mood-right-col">
        <div class="mood-widget-section">
            <div class="rc-title">
                🎵 Get UR Song Of The Day
            </div>
            <iframe
                id="songFrame"
                src="https://open.spotify.com/embed/playlist/40tNsoEvdXyKjdhtbYqc0N?utm_source=generator&si=5cf44484044e4c98"
                width="100%"
                height="152"
                frameborder="0"
                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                loading="lazy">
            </iframe>
          </div>
          </div>
        </div>
      <div class="mood-chips-visual">
          <span class="mood-chip-visual"><img src="images/happy.jpg" width="160"><br>Happy</span>
          <span class="mood-chip-visual"><img src="images/sad.jpg" width="160"><br>Sad</span>
          <span class="mood-chip-visual"><img src="images/tired.jpg" width="160"><br>Tired</span>
          <span class="mood-chip-visual"><img src="images/confident.jpg" width="160"><br>Confident</span>
          <span class="mood-chip-visual"><img src="images/angry.jpg" width="160"><br>Angry</span>
          <span class="mood-chip-visual"><img src="images/nervous.jpg" width="160"><br>Nervous</span>
        </div>
        <hr style="margin:30px 0;">
        <h3 style="margin-bottom:15px;">Mood History</h3>
        <div id="mood-history-container">
        <p>Loading mood history...</p>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
// ==========================================
// 1. DASHBOARD APPLICATION RUNTIME ENGINE STATE
// ==========================================
let appData = {
  userInfo: { full_name: "Student Account", major: "Software Engineering", year: "3" },
  currentMood: "Okay",
  wellnessScore: 78,
  waterAmount: 1.5,
  mealsEaten: 2,
  totalMeals: 3,
  tasks: [
    { id: 101, name: "Advanced Math Worksheet", tag: "Urgent · 2 days", status: "pending" },
    { id: 102, name: "UI/UX Interactive System Prototype", tag: "Design Lab", status: "pending" },
    { id: 103, name: "Technical Documentation Final Draft", tag: "Completed", status: "done" }
  ],
  schedule: {
    "09:00 AM": { name: "CS-302 Lecture Room B", type: "class", sub: "Core Computing Architectures Lecture" },
    "11:00 AM": { name: "Open Practical Laboratory Work", type: "study", sub: "Individual code implementation window" },
    "01:00 PM": { name: "Mid-day Routine Recess", type: "break", sub: "Nutritional meal break window" },
    "03:00 PM": { name: "System Operations Midterm Assessment", type: "test", sub: "Evaluated quiz assembly room" }
  },
  fitSteps: 7420,
  nutritionCalories: 1680
};

// Tracking keys for modification pipelines
let originalEditingTimeKey = null;
let currentEditingTaskId = null;

// ==========================================
// 2. REMOTE DATABASE SYNCHRONIZER
// ==========================================
function loadDashboardFromDatabase() {
  fetch('loginRelated/get_dashboard.php')
    .then(res => { if (!res.ok) throw new Error(); return res.json(); })
    .then(data => {
      if (data.error) { window.location.href = "loginRelated/login.php"; return; }

      if(data.userInfo) appData.userInfo = data.userInfo;
      if(data.currentMood) appData.currentMood = data.currentMood;
      if(data.wellnessScore !== undefined) appData.wellnessScore = parseInt(data.wellnessScore);
      if(data.waterAmount !== undefined) appData.waterAmount = parseFloat(data.waterAmount);
      if(data.mealsEaten !== undefined) appData.mealsEaten = parseInt(data.mealsEaten);
      if(data.tasks) appData.tasks = data.tasks;
      if(data.schedule) appData.schedule = data.schedule;
      if(data.fitSteps !== undefined) appData.fitSteps = parseInt(data.fitSteps);
      if(data.nutritionCalories !== undefined) appData.nutritionCalories = parseInt(data.nutritionCalories);

      syncStaticProfileView();
      renderAll();
    })
    .catch(err => {
      console.log("Running on Local Simulation Mode. Remote database link suspended.");
      syncStaticProfileView();
      renderAll();
    });
}

function syncStaticProfileView() {
  document.querySelector('.nav-name').innerText = appData.userInfo.full_name;
  document.querySelector('.nav-sub').innerText = `Year ${appData.userInfo.year} · ${appData.userInfo.major}`;

  document.querySelectorAll('.mood-chip').forEach(chip => {
    chip.classList.remove('sel');
    if (chip.innerText.trim() === appData.currentMood) chip.classList.add('sel');
  });
}

// ==========================================
// 3. GRAPHICAL USER INTERFACE RENDERING PIPELINE
// ==========================================
function renderAll() {
  renderTimeline();
  renderTasks();
  renderStats();
  renderWellnessMetrics();
}

function renderTimeline() {
  const container = document.getElementById("timeline-container");
  if (!container) return;

  container.innerHTML = Object.keys(appData.schedule).map(hour => {
    const slot = appData.schedule[hour];
    return `
      <div class="tl-hour">
        <span class="tl-time">${hour}</span>
        <div class="tl-slot">
          <div class="tl-block ${slot.type || 'free'}">
            <div class="tl-block-name">${slot.name}</div>
            ${slot.sub ? `<div class="tl-block-sub">${slot.sub}</div>` : ""}
          </div>
        </div>
      </div>`;
  }).join('');
}

function renderTasks() {
  const activeContainer = document.getElementById("tasks-container");
  const historyContainer = document.getElementById("tasks-history-container");
  if (!activeContainer || !historyContainer) return;

  const pendingTasks = appData.tasks.filter(t => t.status === "pending");
  const completedTasks = appData.tasks.filter(t => t.status === "done");

  const sidebarBadge = document.querySelector('.nav-badge.red');
  if (sidebarBadge) sidebarBadge.innerText = pendingTasks.length;

  if (pendingTasks.length === 0) {
    activeContainer.innerHTML = `<div style="font-size:12px; color:var(--text-muted); padding:10px 0; text-align:center;">All clear for the day!</div>`;
  } else {
    activeContainer.innerHTML = pendingTasks.map(task => {
      let tagClass = "amber";
      if (task.tag && (task.tag.includes("Urgent") || task.tag.includes("days"))) tagClass = "red";

      return `
        <div class="task-row">
          <div style="display:flex; align-items:center; gap:10px; flex:1; min-width:0;">
            <input type="checkbox" onchange="toggleTaskStatus(${task.id}, this.checked)" style="accent-color:var(--purple-main); cursor:pointer; width:15px; height:15px; flex-shrink:0;">
            <span class="tname" style="color:var(--text-primary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${task.name}</span>
          </div>
          <span class="ttag ${tagClass}" style="flex-shrink:0; margin-left:8px;">${task.tag || 'Active'}</span>
        </div>`;
    }).join('');
  }

  if (completedTasks.length === 0) {
    historyContainer.innerHTML = `<div style="font-size:11px; color:var(--text-muted); padding:10px 0; text-align:center;">No tasks completed yet.</div>`;
  } else {
    historyContainer.innerHTML = completedTasks.map(task => {
      return `
        <div class="task-row" style="opacity: 0.65;">
          <div style="display:flex; align-items:center; gap:10px; flex:1; min-width:0;">
            <input type="checkbox" checked onchange="toggleTaskStatus(${task.id}, this.checked)" style="accent-color:var(--purple-main); cursor:pointer; width:15px; height:15px; flex-shrink:0;">
            <span class="tname" style="color:var(--text-muted); text-decoration:line-through; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${task.name}</span>
          </div>
          <span class="ttag green" style="flex-shrink:0; margin-left:8px;">Done</span>
        </div>`;
    }).join('');
  }
}

function renderStats() {
  const pendingCount = appData.tasks.filter(t => t.status === "pending").length;

  if (document.getElementById("stat-tasks-due")) document.getElementById("stat-tasks-due").innerText = pendingCount;
  if (document.getElementById("stat-wellness-score")) document.getElementById("stat-wellness-score").innerText = `${appData.wellnessScore}%`;

  const nextDeadlineElement = document.getElementById("stat-next-deadline");
  if (nextDeadlineElement) {
    const urgentTasks = appData.tasks.filter(t => t.status === "pending");
    nextDeadlineElement.innerText = urgentTasks.length > 0 ? urgentTasks[0].name : "None Pending";
  }

  const freeTimeElement = document.getElementById("stat-free-time");
  if (freeTimeElement) {
    let freeHours = 0;
    Object.values(appData.schedule).forEach(slot => { if(slot.type === 'free' || slot.type === 'break') freeHours += 2; });
    freeTimeElement.innerText = `${freeHours || 4}h`;
  }
}

function renderWellnessMetrics() {
  const stepBar = document.getElementById('fit-step-bar');
  const stepVal = document.getElementById('fit-step-val');
  if (stepBar && stepVal) {
    stepVal.innerText = appData.fitSteps.toLocaleString();
    stepBar.style.width = `${Math.min((appData.fitSteps / 10000) * 100, 100)}%`;
  }

  const waterVal = document.getElementById('water-val');
  const waterBar = document.getElementById('water-bar-fill');
  if (waterVal && waterBar) {
    waterVal.innerText = `${appData.waterAmount.toFixed(2)}L`;
    waterBar.style.width = `${Math.min((appData.waterAmount / 3.0) * 100, 100)}%`;
  }

  const mealVal = document.getElementById('meals-val');
  const mealBar = document.getElementById('meals-bar-fill');
  if (mealVal && mealBar) {
    mealVal.innerText = `${appData.mealsEaten}/${appData.totalMeals}`;
    mealBar.style.width = `${(appData.mealsEaten / appData.totalMeals) * 100}%`;
  }

  const calorieBar = document.getElementById('nutrition-calorie-bar');
  const calorieVal = document.getElementById('nutrition-calorie-val');
  if (calorieBar && calorieVal) {
    calorieVal.innerText = `${appData.nutritionCalories}kcal`;
    calorieBar.style.width = `${Math.min((appData.nutritionCalories / 2500) * 100, 100)}%`;
  }

  const cbtText = document.getElementById('srs-cbt-text');
  const alertPanel = document.getElementById('srs-alert-panel');
  if (cbtText) {
    if (appData.currentMood === "Tired") {
      cbtText.innerText = "Circadian Check: Avoid taking long naps late in the afternoon to optimize deep sleep recovery cycles.";
      if (alertPanel) alertPanel.style.display = "flex";
    } else if (appData.currentMood === "Okay") {
      cbtText.innerText = "Pacing Recommendation: Partition remaining workflow modules into 25-minute slots to curb brain strain.";
      if (alertPanel) alertPanel.style.display = "none";
    } else {
      cbtText.innerText = "Excellent consistency balance logged. Continual accurate records sharpen prediction rules.";
      if (alertPanel) alertPanel.style.display = "none";
    }
  }

  const recText = document.getElementById('srs-rec-text');
  if (recText) {
    if (appData.currentMood === "Tired") {
      recText.innerText = "Energy reserves tracking low. Recommendation: Dedicate your next available free slot entirely to active stretching and hydration.";
    } else if (appData.waterAmount < 1.0) {
      recText.innerText = "Hydration metrics have dropped below daily targeted curves. Secure water intake inside your upcoming module transition gap.";
    } else {
      recText.innerText = "All metric paths appear balanced. Follow current class vectors to ensure assignment completion metrics stay on target.";
    }
  }
}

// ==========================================
// 4. METRIC ACTION CONTROLLERS & DISPATCHERS
// ==========================================
function updateMetric(type, value) {
  if (type === 'water') {
    appData.waterAmount = Math.max(0, appData.waterAmount + value);
    appData.wellnessScore = Math.min(100, Math.max(0, appData.wellnessScore + (value > 0 ? 3 : -3)));
  } else if (type === 'meals') {
    appData.mealsEaten = Math.max(0, Math.min(appData.totalMeals, appData.mealsEaten + value));
    appData.nutritionCalories = Math.max(0, appData.nutritionCalories + (value * 450));
  } else if (type === 'mood') {
    appData.currentMood = value;
    document.querySelectorAll('.mood-chip').forEach(chip => {
      chip.classList.remove('sel');
      if (chip.innerText.trim() === value) chip.classList.add('sel');
    });
  }

  renderAll();

  fetch('loginRelated/save_wellness.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ type: type, value: value })
  })
  .then(res => res.json())
  .then(data => {
    if (data && data.wellnessScore !== undefined) {
      appData.wellnessScore = parseInt(data.wellnessScore);
      renderStats();
    }
  })
  .catch(err => console.log("State preserved locally."));
}

function toggleTaskStatus(taskId, isChecked) {
  let task = appData.tasks.find(t => t.id === taskId);
  if (task) {
    task.status = isChecked ? 'done' : 'pending';
    appData.wellnessScore = Math.min(100, appData.wellnessScore + (isChecked ? 5 : -5));
  }
  renderAll();

  fetch('loginRelated/save_wellness.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ type: 'toggle_task', id: taskId, status: isChecked ? 'done' : 'pending' })
  })
  .catch(err => console.log("Task change cached locally."));
}

// Dynamic Navigation
document.querySelectorAll('.nav-item').forEach(btn => {
  btn.onclick = () => {
    const targetId = btn.getAttribute('data-target');
    if (!targetId || !document.getElementById(targetId)) return;

    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.page-view').forEach(page => page.style.display = 'none');
    document.getElementById(targetId).style.display = 'block';
  };
});

document.querySelectorAll('.mood-chip').forEach(chip => {
  chip.onclick = () => updateMetric('mood', chip.innerText.trim());
});

document.querySelectorAll('.mood-chip-visual').forEach(chip => {
    chip.addEventListener('click', () => {

        document.querySelectorAll('.mood-chip-visual')
            .forEach(c => c.classList.remove('sel'));

        chip.classList.add('sel');

        const mood = chip.innerText.trim();

        updateMetric('mood', mood);

        setTimeout(() => {
            loadMoodHistory();
        }, 500);

    });
});

document.querySelectorAll('.tl-day').forEach(dayBtn => {
  dayBtn.addEventListener('click', () => {
    document.querySelectorAll('.tl-day').forEach(b => b.classList.remove('active'));
    dayBtn.classList.add('active');
  });
});



// ========================================================
// 5. EXTENDED RENDERING & EVENT CONTROLLERS FOR VIEW SCREEN SYNC
// ========================================================
const originalRenderAll = renderAll;
renderAll = function() {
  originalRenderAll();
  renderExtendedViews();
};

function renderExtendedViews() {
  // Schedule Management List Renderer
  const schedList = document.getElementById("schedule-list-view");
  if (schedList) {
    schedList.innerHTML = Object.keys(appData.schedule).sort().map(hour => {
      const slot = appData.schedule[hour];
      return `
        <div style="padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--bg-card); display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow);">
          <div>
            <strong style="color: var(--purple-main); font-size: 13px;">${hour}</strong> — <span style="font-size: 13px; font-weight: 600;">${slot.name}</span>
            <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">${slot.sub || 'No extra descriptions provided.'}</div>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <span class="ttag ${slot.type === 'class' ? 'purple' : slot.type === 'test' ? 'red' : slot.type === 'break' ? 'green' : slot.type === 'study' ? 'amber' : 'free'}" style="text-transform: uppercase; font-size: 10px;">${slot.type}</span>
            <div class="action-btn-group">
              <button class="action-icon-btn" title="Edit Schedule Slot" onclick="editScheduleSlot('${hour}')">
                <i class="ti ti-edit"></i>
              </button>
              <button class="action-icon-btn delete" title="Delete Schedule Slot" onclick="deleteScheduleSlot('${hour}')">
                <i class="ti ti-trash"></i>
              </button>
            </div>
          </div>
        </div>`;
    }).join('');
  }

  // Tasks Management List Renderer (UPDATED: Added Action Buttons here too!)
  const tasksList = document.getElementById("tasks-list-view");
  if (tasksList) {
    if (appData.tasks.length === 0) {
      tasksList.innerHTML = `<div style="text-align:center; padding: 20px; color: var(--text-muted); font-size: 13px;">No active entries mapped.</div>`;
      return;
    }
    tasksList.innerHTML = appData.tasks.map(task => {
      const isDone = task.status === "done";
      let tagClass = "amber";
      if (isDone) tagClass = "green";
      else if (task.tag && (task.tag.includes("Urgent") || task.tag.includes("days"))) tagClass = "red";

      return `
        <div style="padding: 12px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--bg-card); display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow);">
          <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
            <input type="checkbox" ${isDone ? 'checked' : ''} onchange="toggleTaskStatus(${task.id}, this.checked)" style="accent-color:var(--purple-main); cursor:pointer; width:15px; height:15px; flex-shrink:0;">
            <span style="font-size: 13px; font-weight: 500; text-decoration: ${isDone ? 'line-through' : 'none'}; color: ${isDone ? 'var(--text-muted)' : 'var(--text-primary)'}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${task.name}</span>
          </div>
          <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0; margin-left: 8px;">
            <span class="ttag ${tagClass}">${task.tag}</span>
            <div class="action-btn-group">
              <button class="action-icon-btn" title="Edit Task" onclick="editCourseTask(${task.id})">
                <i class="ti ti-edit"></i>
              </button>
              <button class="action-icon-btn delete" title="Delete Task" onclick="deleteCourseTask(${task.id})">
                <i class="ti ti-trash"></i>
              </button>
            </div>
          </div>
        </div>`;
    }).join('');
  }
}

// ── SCHEDULE MODULE ACTIONS ──
function editScheduleSlot(hourKey) {
  const slot = appData.schedule[hourKey];
  if (!slot) return;
  document.getElementById("sched-time").value = hourKey;
  document.getElementById("sched-name").value = slot.name;
  document.getElementById("sched-sub").value = slot.sub || "";
  document.getElementById("sched-type").value = slot.type || "class";
  document.getElementById("schedule-form-title").innerText = "Modify Selected Schedule Block";
  document.getElementById("sched-submit-btn").innerText = "Update Slot Info";
  document.getElementById("sched-cancel-btn").style.display = "inline-block";
  originalEditingTimeKey = hourKey;
}

function deleteScheduleSlot(hourKey) {
  if (confirm(`Are you sure you want to remove the slot at ${hourKey}?`)) {
    delete appData.schedule[hourKey];
    renderAll();
  }
}

function clearScheduleForm() {
  document.getElementById("add-schedule-form").reset();
  document.getElementById("schedule-form-title").innerText = "Add New Schedule Block";
  document.getElementById("sched-submit-btn").innerText = "Add to Calendar";
  document.getElementById("sched-cancel-btn").style.display = "none";
  originalEditingTimeKey = null;
}

function addNewScheduleSlot() {
  const hour = document.getElementById("sched-time").value.trim();
  const name = document.getElementById("sched-name").value.trim();
  const sub = document.getElementById("sched-sub").value.trim();
  const type = document.getElementById("sched-type").value;

  if (hour && name) {
    if (originalEditingTimeKey && originalEditingTimeKey !== hour) {
      delete appData.schedule[originalEditingTimeKey];
    }
    appData.schedule[hour] = { name, type, sub };
    renderAll();
    clearScheduleForm();
  }
}

// ── NEW TASK MODULE ACTIONS: EDIT & DELETE ──
function editCourseTask(taskId) {
  const task = appData.tasks.find(t => t.id === taskId);
  if (!task) return;

  // Load current properties into inputs
  document.getElementById("task-name-input").value = task.name;
  document.getElementById("task-tag-input").value = task.tag;

  // Change headers to reflect update context
  document.getElementById("task-form-title").innerText = "Modify Course Assignment";
  document.getElementById("task-submit-btn").innerText = "Save Task Changes";
  document.getElementById("task-cancel-btn").style.display = "inline-block";

  currentEditingTaskId = taskId;
}

function deleteCourseTask(taskId) {
  if (confirm("Are you sure you want to permanently remove this course assignment?")) {
    appData.tasks = appData.tasks.filter(t => t.id !== taskId);
    renderAll();

    // Safety check if user deletes a task while editing it
    if (currentEditingTaskId === taskId) {
      clearTaskForm();
    }
  }
}

function clearTaskForm() {
  document.getElementById("add-task-form").reset();
  document.getElementById("task-form-title").innerText = "Create Course Assignment / Task";
  document.getElementById("task-submit-btn").innerText = "Append Task";
  document.getElementById("task-cancel-btn").style.display = "none";
  currentEditingTaskId = null;
}

function addNewCourseTask() {
  const name = document.getElementById("task-name-input").value.trim();
  const tag = document.getElementById("task-tag-input").value.trim();

  if (name && tag) {
    if (currentEditingTaskId !== null) {
      // Find and update existing structural entry object
      let task = appData.tasks.find(t => t.id === currentEditingTaskId);
      if (task) {
        task.name = name;
        task.tag = tag;
      }
    } else {
      // If not editing, create a brand new task
      const id = Date.now();
      appData.tasks.push({ id, name, tag, status: "pending" });
    }

    renderAll();
    clearTaskForm();
  }
}
!function(d,s,id){
  var js,fjs=d.getElementsByTagName(s)[0];
  if(!d.getElementById(id)){
    js=d.createElement(s);
    js.id=id;
    js.src='https://weatherwidget.io/js/widget.min.js';
    fjs.parentNode.insertBefore(js,fjs);}
  }
(document,'script','weatherwidget-io-js');
function loadMoodHistory() {
    fetch('loginRelated/get_mood_history.php')
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('mood-history-container');
            if(data.length === 0){
                container.innerHTML =
                    "<p>No mood history available.</p>";
                return;
            }
            let html = `
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <th>Date</th>
                        <th>Mood</th>
                    </tr>
            `;
            data.forEach(item => {
                html += `
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">
                            ${item.log_date}
                        </td>

                        <td style="padding:10px; border:1px solid #ddd;">
                            ${item.mood}
                        </td>
                    </tr>
                `;
            });
            html += "</table>";
            container.innerHTML = html;
        });
}
  // QUOTE OF THE DAY
    window.onload = function() {

    const quotes = [
      "Believe you can and you're halfway there.",
      "Small progress is still progress.",
      "Take care of yourself. You deserve it.",
      "Every day is a fresh start.",
      "Your mental health matters."
    ];

    const today = new Date().getDate();

    document.getElementById("dailyQuote").textContent =
      quotes[today % quotes.length];
};


    function updateDate() {
        const dateElement = document.getElementById("currentDate");

        const options = {
            weekday: 'long',
            month: 'short',
            day: 'numeric',
            timeZone: 'Asia/Kuala_Lumpur'
        };

        dateElement.textContent =
            new Date().toLocaleDateString('en-US', options);
    }
    updateDate();
    loadDashboardFromDatabase();
    loadMoodHistory();
</script>
</body>
</html>