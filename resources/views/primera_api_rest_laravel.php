<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tu Primera API REST con Laravel — CEFIT</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

:root {
  --bg: #0d1117; --bg2: #161b22; --bg3: #21262d; --bg4: #2d333b;
  --border: #30363d; --border2: #444c56;
  --text: #e6edf3; --text2: #8b949e; --text3: #484f58;
  --green: #3fb950; --green-bg: #0d1f12; --green-dim: #1a4222;
  --blue: #58a6ff; --blue-bg: #0c1e35; --blue-dim: #132d52;
  --purple: #bc8cff; --purple-bg: #1a1035;
  --orange: #f0883e; --orange-bg: #2d1a0a;
  --red: #f85149; --red-bg: #2d0f0e;
  --yellow: #e3b341; --yellow-bg: #2b2008;
  --teal: #56d364; --teal-bg: #0a2a14;
  --mono: 'JetBrains Mono', monospace;
  --sans: 'Inter', sans-serif;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
  background: var(--bg);
  color: var(--text);
  font-family: var(--sans);
  font-size: 15px;
  line-height: 1.7;
}

/* ── LAYOUT ── */
.app { display: flex; min-height: 100vh; }

.sidebar {
  width: 270px; min-width: 270px;
  background: var(--bg2);
  border-right: 1px solid var(--border);
  position: sticky; top: 0; height: 100vh;
  overflow-y: auto;
  display: flex; flex-direction: column;
}

.main { flex: 1; overflow-x: hidden; }

/* ── SIDEBAR ── */
.sidebar-logo {
  padding: 20px 18px 16px;
  border-bottom: 1px solid var(--border);
}

.logo-badge {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--mono); font-size: 11px; font-weight: 700;
  color: var(--green); background: var(--green-bg);
  border: 1px solid var(--green-dim);
  border-radius: 5px; padding: 4px 10px; margin-bottom: 8px;
}

.logo-title { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.4; }
.logo-sub { font-size: 11px; color: var(--text3); margin-top: 2px; font-family: var(--mono); }

.prog-wrap { padding: 14px 18px; border-bottom: 1px solid var(--border); }
.prog-row { display: flex; justify-content: space-between; font-size: 11px; color: var(--text2); margin-bottom: 5px; }
.prog-track { height: 3px; background: var(--bg4); border-radius: 2px; overflow: hidden; }
.prog-fill { height: 100%; background: linear-gradient(90deg, var(--green), var(--blue)); border-radius: 2px; transition: width .4s; }

.nav-section {
  padding: 8px 18px 3px;
  font-size: 10px; font-weight: 600; color: var(--text3);
  text-transform: uppercase; letter-spacing: .08em;
  font-family: var(--mono);
}

.nav-item {
  display: flex; align-items: center; gap: 9px;
  padding: 6px 18px; cursor: pointer;
  border-left: 2px solid transparent;
  font-size: 12px; color: var(--text2);
  transition: all .12s;
}
.nav-item:hover { background: var(--bg3); color: var(--text); }
.nav-item.active { background: var(--blue-dim); border-left-color: var(--blue); color: var(--blue); }
.nav-item.done { color: var(--green); }
.nav-num {
  font-family: var(--mono); font-size: 10px; font-weight: 700;
  background: var(--bg4); color: var(--text3);
  border-radius: 3px; padding: 1px 5px; min-width: 26px; text-align: center;
}
.nav-item.active .nav-num { background: var(--blue-dim); color: var(--blue); }
.nav-item.done .nav-num { background: var(--green-dim); color: var(--green); }
.nav-check { margin-left: auto; font-size: 11px; opacity: 0; }
.nav-item.done .nav-check { opacity: 1; }

/* ── CONTENT ── */
.page { display: none; max-width: 820px; padding: 44px 52px; }
.page.visible { display: block; }

/* ── WELCOME ── */
.hero { margin-bottom: 40px; }
.eyebrow {
  font-family: var(--mono); font-size: 11px; font-weight: 600;
  color: var(--green); text-transform: uppercase; letter-spacing: .1em;
  margin-bottom: 14px;
}
.hero-title { font-size: 34px; font-weight: 700; line-height: 1.2; margin-bottom: 14px; }
.hero-title span { color: var(--blue); }
.hero-desc { font-size: 15px; color: var(--text2); max-width: 560px; line-height: 1.7; }

.cards-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin: 24px 0; }
.card-item {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; padding: 14px 16px;
}
.card-item-label { font-size: 10px; font-family: var(--mono); color: var(--text3); text-transform: uppercase; letter-spacing: .07em; margin-bottom: 5px; }
.card-item-val { font-size: 13px; font-weight: 600; color: var(--text); }

.step-cards { display: grid; gap: 10px; margin-top: 20px; }
.step-card {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 9px; padding: 16px 18px;
  display: flex; gap: 14px; align-items: flex-start;
  cursor: pointer; transition: border-color .15s, background .15s;
}
.step-card:hover { border-color: var(--blue); background: var(--blue-bg); }
.step-num { font-family: var(--mono); font-size: 20px; font-weight: 700; color: var(--blue); min-width: 32px; line-height: 1.2; padding-top: 2px; }
.step-info { flex: 1; }
.step-title { font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 3px; }
.step-desc { font-size: 12px; color: var(--text2); }
.step-dur {
  font-family: var(--mono); font-size: 10px; color: var(--text3);
  background: var(--bg4); border-radius: 3px; padding: 2px 7px;
  margin-top: 5px; display: inline-block;
}

/* ── PHASE ── */
.phase-hdr { margin-bottom: 32px; padding-bottom: 22px; border-bottom: 1px solid var(--border); }
.phase-tag { font-family: var(--mono); font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 10px; }
.phase-title { font-size: 26px; font-weight: 700; line-height: 1.3; margin-bottom: 10px; }
.phase-goal {
  font-size: 13px; color: var(--text2);
  background: var(--blue-bg); border: 1px solid var(--blue-dim);
  border-left: 3px solid var(--blue); border-radius: 6px; padding: 11px 15px;
}
.phase-goal strong { color: var(--blue); }

.sec { margin-bottom: 32px; }
.sec-title {
  font-size: 12px; font-weight: 700; color: var(--text2);
  text-transform: uppercase; letter-spacing: .08em;
  font-family: var(--mono); margin-bottom: 12px;
  display: flex; align-items: center; gap: 8px;
}
.sec-title::after { content:''; flex:1; height:1px; background: var(--border); }

/* concept box */
.concept {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; padding: 18px 20px; margin-bottom: 14px;
}
.concept-title { font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 7px; }
.concept-body { font-size: 13px; color: var(--text2); line-height: 1.7; }
.concept-body p { margin-bottom: 8px; }
.concept-body p:last-child { margin-bottom: 0; }

.analogy {
  background: var(--yellow-bg); border: 1px solid #3d2d0a;
  border-radius: 5px; padding: 10px 14px;
  font-size: 12px; color: var(--yellow); margin-top: 10px; line-height: 1.6;
}
.analogy::before { content: '💡 '; }

/* code block */
.code-block {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; overflow: hidden; margin-bottom: 14px;
}
.code-hdr {
  display: flex; align-items: center; justify-content: space-between;
  padding: 7px 14px; background: var(--bg3);
  border-bottom: 1px solid var(--border);
  font-family: var(--mono); font-size: 11px; color: var(--text3);
}
.code-lang { color: var(--green); font-weight: 600; }
.copy-btn {
  background: var(--bg4); border: 1px solid var(--border);
  color: var(--text2); border-radius: 3px;
  padding: 2px 9px; font-size: 11px; font-family: var(--mono);
  cursor: pointer; transition: all .15s;
}
.copy-btn:hover { background: var(--border2); color: var(--text); }
.copy-btn.ok { color: var(--green); border-color: var(--green-dim); }

pre { padding: 16px; overflow-x: auto; font-family: var(--mono); font-size: 13px; line-height: 1.65; }
pre code { background: none; padding: 0; }

/* syntax */
.kw { color: #ff7b72; }
.fn { color: #d2a8ff; }
.str { color: #a5d6ff; }
.cm { color: var(--text3); font-style: italic; }
.num { color: #79c0ff; }
.cls { color: #ffa657; }
.http-get { color: var(--green); font-weight: 700; }
.http-post { color: var(--blue); font-weight: 700; }
.http-put { color: var(--orange); font-weight: 700; }
.http-del { color: var(--red); font-weight: 700; }
.http-hdr { color: var(--purple); }
.http-body-c { color: var(--yellow); }

/* bash */
.bash {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; overflow: hidden; margin-bottom: 14px;
}
.bash-hdr {
  display: flex; align-items: center; gap: 6px;
  padding: 7px 14px; background: var(--bg3);
  border-bottom: 1px solid var(--border);
  font-family: var(--mono); font-size: 11px; color: var(--text3);
}
.dot { width: 8px; height: 8px; border-radius: 50%; }
.bash-body { padding: 13px 16px; font-family: var(--mono); font-size: 13px; }
.bash-line { display: flex; gap: 9px; padding: 2px 0; }
.prompt { color: var(--green); user-select: none; }
.cmd { color: var(--text); flex: 1; }
.bash-cm { color: var(--text3); font-style: italic; }

/* steps list */
.steps { display: grid; gap: 10px; }
.step {
  display: flex; gap: 14px;
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; padding: 14px 16px;
}
.sn { font-family: var(--mono); font-size: 17px; font-weight: 700; color: var(--blue); min-width: 26px; line-height: 1.3; }
.sc { flex: 1; }
.st { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
.sb { font-size: 12px; color: var(--text2); line-height: 1.6; }

/* info boxes */
.info {
  border-radius: 7px; padding: 12px 16px;
  font-size: 13px; margin-bottom: 14px; line-height: 1.6;
}
.info.tip { background: var(--green-bg); border: 1px solid var(--green-dim); color: #7ee787; }
.info.warn { background: var(--yellow-bg); border: 1px solid #3d2d0a; color: var(--yellow); }
.info.note { background: var(--blue-bg); border: 1px solid var(--blue-dim); color: var(--blue); }
.info.err { background: var(--red-bg); border: 1px solid #4a1a1a; color: #ff8080; }
.info-lbl { font-weight: 700; font-family: var(--mono); font-size: 10px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px; }

/* file tree */
.tree {
  font-family: var(--mono); font-size: 13px; line-height: 1.9;
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: 8px; padding: 16px 18px; margin-bottom: 14px;
}
.td { color: var(--blue); }
.tf { color: var(--text); }
.tn { color: var(--green); }
.tc { color: var(--text3); }

/* table */
.tbl { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 14px; }
.tbl th { background: var(--bg3); padding: 7px 12px; text-align: left; color: var(--text3); font-weight: 600; border-bottom: 1px solid var(--border); font-size: 11px; text-transform: uppercase; letter-spacing: .05em; font-family: var(--mono); }
.tbl td { padding: 8px 12px; border-bottom: 1px solid var(--border); vertical-align: top; }
.tbl tr:last-child td { border-bottom: none; }
.tbl tr:hover td { background: var(--bg3); }

/* tags */
.tag { display: inline-block; font-family: var(--mono); font-size: 11px; font-weight: 700; border-radius: 3px; padding: 2px 7px; margin-right: 3px; }
.tag-g { background: var(--green-dim); color: var(--green); }
.tag-b { background: var(--blue-dim); color: var(--blue); }
.tag-o { background: var(--orange-bg); color: var(--orange); }
.tag-r { background: var(--red-bg); color: var(--red); }
.tag-y { background: var(--yellow-bg); color: var(--yellow); }

/* deliverable */
.deliv {
  background: var(--green-bg); border: 1px solid var(--green-dim);
  border-left: 3px solid var(--green);
  border-radius: 8px; padding: 14px 18px; margin-top: 24px;
}
.deliv-lbl { font-family: var(--mono); font-size: 10px; font-weight: 700; color: var(--green); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 7px; }
.deliv-title { font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 5px; }
.deliv ul { list-style: none; padding: 0; font-size: 12px; color: #7ee787; }
.deliv li::before { content: '✓ '; }

/* complete btn */
.done-btn {
  display: inline-flex; align-items: center; gap: 7px;
  margin-top: 24px; padding: 9px 18px;
  background: var(--green-dim); border: 1px solid var(--green);
  color: var(--green); border-radius: 5px;
  font-family: var(--mono); font-size: 12px; font-weight: 600;
  cursor: pointer; transition: all .2s;
}
.done-btn:hover { background: var(--green); color: var(--bg); }
.done-btn.done { background: var(--green); color: var(--bg); }

/* pager */
.pager {
  display: flex; justify-content: space-between; align-items: center;
  margin-top: 44px; padding-top: 22px; border-top: 1px solid var(--border);
}
.pg-btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 8px 16px; background: var(--bg2);
  border: 1px solid var(--border); color: var(--text2);
  border-radius: 5px; font-size: 13px; cursor: pointer; transition: all .2s;
  font-family: var(--sans);
}
.pg-btn:hover { border-color: var(--blue); color: var(--blue); }
.pg-btn:disabled { opacity: .3; cursor: not-allowed; }
.pg-ind { font-family: var(--mono); font-size: 11px; color: var(--text3); }

/* flow */
.flow { display: flex; align-items: center; gap: 0; margin: 16px 0; flex-wrap: wrap; }
.fb { background: var(--bg2); border: 1px solid var(--border); border-radius: 7px; padding: 10px 16px; font-size: 12px; font-weight: 500; text-align: center; min-width: 110px; }
.fb.g { border-color: var(--green-dim); background: var(--green-bg); color: var(--green); }
.fb.b { border-color: var(--blue-dim); background: var(--blue-bg); color: var(--blue); }
.fb.o { border-color: #3d2205; background: var(--orange-bg); color: var(--orange); }
.fb.p { border-color: #2d1f55; background: var(--purple-bg); color: var(--purple); }
.fa { color: var(--text3); font-size: 16px; padding: 0 5px; }

/* highlight inline code */
code { font-family: var(--mono); font-size: 12px; background: var(--bg3); border: 1px solid var(--border); border-radius: 3px; padding: 1px 5px; color: var(--text); }

::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--bg2); }
::-webkit-scrollbar-thumb { background: var(--bg4); border-radius: 3px; }

kbd { font-family: var(--mono); font-size: 11px; background: var(--bg3); border: 1px solid var(--border2); border-radius: 3px; padding: 1px 6px; color: var(--text); }

@media(max-width:860px){
  .sidebar { display: none; }
  .page { padding: 24px 20px; }
  .cards-grid { grid-template-columns: 1fr 1fr; }
}
</style>
</head>
<body>
<div class="app">

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-badge">⚡ api-practica</div>
    <div class="logo-title">Tu primera API REST<br>con Laravel</div>
    <div class="logo-sub">CEFIT · Sesión A</div>
  </div>
  <div class="prog-wrap">
    <div class="prog-row"><span>Progreso</span><span id="prog-text">0 / 7</span></div>
    <div class="prog-track"><div class="prog-fill" id="prog-bar" style="width:0%"></div></div>
  </div>
  <nav style="padding:10px 0;flex:1">
    <div class="nav-section">Inicio</div>
    <div class="nav-item active" onclick="show('welcome',this)">
      <span class="nav-num">00</span>¿Qué vas a construir?
    </div>
    <div class="nav-section" style="margin-top:6px">Conceptos</div>
    <div class="nav-item" id="nav-c1" onclick="show('c1',this)">
      <span class="nav-num">C1</span>HTTP y JSON
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-item" id="nav-c2" onclick="show('c2',this)">
      <span class="nav-num">C2</span>Verbos y recursos
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-section" style="margin-top:6px">Práctica</div>
    <div class="nav-item" id="nav-p1" onclick="show('p1',this)">
      <span class="nav-num">P1</span>Crear el proyecto
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-item" id="nav-p2" onclick="show('p2',this)">
      <span class="nav-num">P2</span>Primera ruta API
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-item" id="nav-p3" onclick="show('p3',this)">
      <span class="nav-num">P3</span>Modelo + Controller
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-item" id="nav-p4" onclick="show('p4',this)">
      <span class="nav-num">P4</span>HTTP Client · Probar
      <span class="nav-check">✓</span>
    </div>
    <div class="nav-item" id="nav-p5" onclick="show('p5',this)">
      <span class="nav-num">P5</span>CRUD completo
      <span class="nav-check">✓</span>
    </div>
  </nav>
</aside>

<!-- MAIN -->
<main class="main">

<!-- ══ WELCOME ══ -->
<div class="page visible" id="page-welcome">
  <div class="hero">
    <div class="eyebrow">CEFIT · Sesión A · Primera API</div>
    <h1 class="hero-title">Tu primera<br><span>API REST</span> con Laravel</h1>
    <p class="hero-desc">
      Vas a construir una API desde cero sobre un proyecto nuevo. Sin Blade, sin vistas. Solo rutas que devuelven JSON. Al final vas a tener un CRUD completo que cualquier app puede consumir.
    </p>
  </div>

  <div class="cards-grid">
    <div class="card-item"><div class="card-item-label">Proyecto</div><div class="card-item-val">api-practica</div></div>
    <div class="card-item"><div class="card-item-label">Stack</div><div class="card-item-val">Laravel 12 + SQLite</div></div>
    <div class="card-item"><div class="card-item-label">Cliente</div><div class="card-item-val">HTTP Client JetBrains</div></div>
  </div>

  <div class="sec-title" style="margin-top:8px">Ruta de aprendizaje</div>
  <div class="step-cards">
    <div class="step-card" onclick="show('c1',document.getElementById('nav-c1'))">
      <div class="step-num">C1</div>
      <div class="step-info">
        <div class="step-title">HTTP y JSON — el idioma de las APIs</div>
        <div class="step-desc">Cómo se comunican dos apps, qué es una petición, qué es una respuesta.</div>
        <div class="step-dur">concepto · 10 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('c2',document.getElementById('nav-c2'))">
      <div class="step-num">C2</div>
      <div class="step-info">
        <div class="step-title">Verbos HTTP y recursos REST</div>
        <div class="step-desc">GET, POST, PUT, DELETE. Qué significa cada uno y cómo se mapea a acciones reales.</div>
        <div class="step-dur">concepto · 10 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('p1',document.getElementById('nav-p1'))">
      <div class="step-num">P1</div>
      <div class="step-info">
        <div class="step-title">Crear el proyecto Laravel</div>
        <div class="step-desc">laravel new api-practica. Sin Breeze, sin Blade complejo. Solo lo esencial para una API.</div>
        <div class="step-dur">práctica · 10 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('p2',document.getElementById('nav-p2'))">
      <div class="step-num">P2</div>
      <div class="step-info">
        <div class="step-title">Primera ruta que devuelve JSON</div>
        <div class="step-desc">El "Hola mundo" de las APIs. Una ruta en api.php que responde datos reales.</div>
        <div class="step-dur">práctica · 15 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('p3',document.getElementById('nav-p3'))">
      <div class="step-num">P3</div>
      <div class="step-info">
        <div class="step-title">Modelo + Controller + Migración</div>
        <div class="step-desc">Crear el modelo Cliente con su tabla y el controlador API dedicado.</div>
        <div class="step-dur">práctica · 20 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('p4',document.getElementById('nav-p4'))">
      <div class="step-num">P4</div>
      <div class="step-info">
        <div class="step-title">Probar con el HTTP Client</div>
        <div class="step-desc">Crear archivos .http en PhpStorm/WebStorm y ejecutar peticiones reales.</div>
        <div class="step-dur">práctica · 15 min</div>
      </div>
    </div>
    <div class="step-card" onclick="show('p5',document.getElementById('nav-p5'))">
      <div class="step-num">P5</div>
      <div class="step-info">
        <div class="step-title">CRUD completo</div>
        <div class="step-desc">POST, PUT, DELETE. Validación con status codes correctos. Tu primera API real.</div>
        <div class="step-dur">práctica · 25 min</div>
      </div>
    </div>
  </div>
</div>

<!-- ══ C1: HTTP Y JSON ══ -->
<div class="page" id="page-c1">
  <div class="phase-hdr">
    <div class="phase-tag">Concepto 01 · 10 min</div>
    <h2 class="phase-title">HTTP y JSON —<br>el idioma de las APIs</h2>
    <div class="phase-goal"><strong>Idea clave:</strong> Toda comunicación entre apps en internet usa HTTP. La API es solo una puerta que habla ese idioma y devuelve JSON en vez de HTML.</div>
  </div>

  <div class="sec">
    <div class="sec-title">La conversación HTTP</div>
    <div class="concept">
      <div class="concept-title">Toda petición tiene dos partes</div>
      <div class="concept-body">
        <p>Cuando Flet le pide datos a Laravel, ocurre una conversación de ida y vuelta. <strong style="color:var(--text)">Request</strong> (lo que envía el cliente) y <strong style="color:var(--text)">Response</strong> (lo que devuelve el servidor).</p>
      </div>
    </div>

    <div class="code-block">
      <div class="code-hdr"><span>Request — lo que envía Flet <span class="code-lang">· HTTP</span></span></div>
      <pre><code><span class="http-get">GET</span> /api/clientes HTTP/1.1
<span class="http-hdr">Host</span>: localhost:8000
<span class="http-hdr">Accept</span>: application/json
<span class="http-hdr">Authorization</span>: Bearer mi-token-aqui</code></pre>
    </div>

    <div class="code-block">
      <div class="code-hdr"><span>Response — lo que devuelve Laravel <span class="code-lang">· HTTP</span></span></div>
      <pre><code>HTTP/1.1 <span class="num">200</span> OK
<span class="http-hdr">Content-Type</span>: application/json

<span class="http-body-c">[
  { "id": 1, "nombre": "Ana García", "email": "ana@email.com" },
  { "id": 2, "nombre": "Luis Pérez", "email": "luis@email.com" }
]</span></code></pre>
    </div>

    <div class="concept">
      <div class="concept-title">El Request tiene 4 partes que debes conocer</div>
      <div class="concept-body">
        <table class="tbl" style="margin-top:8px">
          <thead><tr><th>Parte</th><th>Qué es</th><th>Ejemplo</th></tr></thead>
          <tbody>
            <tr><td><code>Verbo</code></td><td>La acción que quieres hacer</td><td><span class="tag tag-g">GET</span> <span class="tag tag-b">POST</span></td></tr>
            <tr><td><code>URL</code></td><td>A qué recurso le hablas</td><td><code>/api/clientes/5</code></td></tr>
            <tr><td><code>Headers</code></td><td>Metadatos de la petición</td><td><code>Accept: application/json</code></td></tr>
            <tr><td><code>Body</code></td><td>Datos que envías (solo POST/PUT)</td><td><code>{"nombre": "Ana"}</code></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">JSON — el formato universal</div>
    <div class="concept">
      <div class="concept-title">¿Por qué JSON y no HTML?</div>
      <div class="concept-body">
        <p>HTML tiene estilos, botones, scripts — es para humanos mirando un navegador. JSON es solo datos estructurados — lo puede leer cualquier lenguaje de programación sin ningún procesamiento extra.</p>
      </div>
      <div class="analogy">Un archivo HTML es como un plato servido con decoración de restaurante. Un JSON es el mismo ingrediente en un tupper — sin decoración, listo para usarse como uno quiera.</div>
    </div>

    <div class="code-block">
      <div class="code-hdr"><span>Estructura JSON válida <span class="code-lang">· JSON</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="http-body-c">{
  "id": 1,
  "nombre": "Ana García",
  "email": "ana@email.com",
  "activo": true,
  "edad": 28,
  "tags": ["cliente", "premium"],
  "direccion": {
    "ciudad": "Medellín",
    "pais": "Colombia"
  }
}</span></code></pre>
    </div>

    <div class="concept">
      <div class="concept-title">Tipos de datos en JSON</div>
      <div class="concept-body">
        <table class="tbl" style="margin-top:6px">
          <thead><tr><th>Tipo</th><th>Ejemplo</th><th>En PHP/Laravel</th></tr></thead>
          <tbody>
            <tr><td>String</td><td><code>"Ana García"</code></td><td><code>string</code></td></tr>
            <tr><td>Number</td><td><code>28</code> / <code>35000.5</code></td><td><code>int</code> / <code>float</code></td></tr>
            <tr><td>Boolean</td><td><code>true</code> / <code>false</code></td><td><code>bool</code></td></tr>
            <tr><td>Array</td><td><code>["a","b","c"]</code></td><td><code>array</code></td></tr>
            <tr><td>Object</td><td><code>{"key": "val"}</code></td><td><code>array asociativo</code></td></tr>
            <tr><td>Null</td><td><code>null</code></td><td><code>null</code></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Checkpoint</div>
    <div class="deliv-title">Debes poder responder</div>
    <ul>
      <li>¿Cuáles son las 4 partes de un HTTP Request?</li>
      <li>¿Por qué usamos JSON y no HTML en una API?</li>
      <li>¿Qué diferencia hay entre Request y Response?</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-c1" onclick="markDone('c1')">✓ Concepto entendido</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('welcome',null)" disabled>← Inicio</button>
    <span class="pg-ind">C1 / 7</span>
    <button class="pg-btn" onclick="show('c2',document.getElementById('nav-c2'))">Concepto 2 →</button>
  </div>
</div>

<!-- ══ C2: VERBOS ══ -->
<div class="page" id="page-c2">
  <div class="phase-hdr">
    <div class="phase-tag">Concepto 02 · 10 min</div>
    <h2 class="phase-title">Verbos HTTP<br>y recursos REST</h2>
    <div class="phase-goal"><strong>Idea clave:</strong> En REST, la URL dice <em>qué cosa</em> tocas y el verbo dice <em>qué haces</em> con ella. GET = leer, POST = crear, PUT/PATCH = editar, DELETE = borrar.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Los 4 verbos esenciales</div>
    <div class="concept">
      <div class="concept-body">
        <table class="tbl">
          <thead><tr><th>Verbo</th><th>Acción</th><th>¿Lleva body?</th><th>Status esperado</th></tr></thead>
          <tbody>
            <tr><td><span class="tag tag-g">GET</span></td><td>Leer datos</td><td>No</td><td><span class="tag tag-g">200</span></td></tr>
            <tr><td><span class="tag tag-b">POST</span></td><td>Crear nuevo</td><td>Sí (JSON)</td><td><span class="tag tag-b">201</span></td></tr>
            <tr><td><span class="tag tag-o">PATCH</span></td><td>Editar parcial</td><td>Sí (JSON)</td><td><span class="tag tag-g">200</span></td></tr>
            <tr><td><span class="tag tag-r">DELETE</span></td><td>Eliminar</td><td>No</td><td><span class="tag tag-g">200</span></td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="concept">
      <div class="concept-title">La misma URL, diferente verbo = diferente acción</div>
      <div class="concept-body">
        <p>Esta es la elegancia de REST. No necesitas URLs distintas para cada operación:</p>
      </div>
    </div>

    <div class="code-block">
      <div class="code-hdr"><span>Misma URL — 5 acciones distintas <span class="code-lang">· REST</span></span></div>
      <pre><code><span class="cm"># Sobre la colección completa:</span>
<span class="http-get">GET</span>    /api/clientes        <span class="cm">→ listar todos</span>
<span class="http-post">POST</span>   /api/clientes        <span class="cm">→ crear uno nuevo</span>

<span class="cm"># Sobre un recurso específico:</span>
<span class="http-get">GET</span>    /api/clientes/<span class="num">5</span>     <span class="cm">→ ver el cliente 5</span>
<span class="http-put">PATCH</span>  /api/clientes/<span class="num">5</span>     <span class="cm">→ editar el cliente 5</span>
<span class="http-del">DELETE</span> /api/clientes/<span class="num">5</span>     <span class="cm">→ eliminar el cliente 5</span></code></pre>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">Status codes — la respuesta habla</div>
    <div class="concept">
      <div class="concept-title">El servidor responde con un número que dice qué pasó</div>
      <div class="concept-body">
        <table class="tbl" style="margin-top:6px">
          <thead><tr><th>Código</th><th>Nombre</th><th>Cuándo usarlo</th></tr></thead>
          <tbody>
            <tr><td><span class="tag tag-g">200</span></td><td>OK</td><td>GET o DELETE exitoso</td></tr>
            <tr><td><span class="tag tag-b">201</span></td><td>Created</td><td>POST que creó un registro</td></tr>
            <tr><td><span class="tag tag-y">400</span></td><td>Bad Request</td><td>El request está mal formado</td></tr>
            <tr><td><span class="tag tag-y">401</span></td><td>Unauthorized</td><td>Falta token de autenticación</td></tr>
            <tr><td><span class="tag tag-y">403</span></td><td>Forbidden</td><td>Token ok, pero sin permiso</td></tr>
            <tr><td><span class="tag tag-r">404</span></td><td>Not Found</td><td>El ID no existe</td></tr>
            <tr><td><span class="tag tag-r">422</span></td><td>Unprocessable</td><td>Falló la validación</td></tr>
            <tr><td><span class="tag tag-r">500</span></td><td>Server Error</td><td>Bug en el servidor</td></tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="analogy" style="background:var(--yellow-bg);border:1px solid #3d2d0a;border-radius:5px;padding:10px 14px;font-size:12px;color:var(--yellow);line-height:1.6;">
      💡 Los status codes son como las señales de tránsito. El 200 es luz verde. El 404 es "esa calle no existe". El 401 es "necesitas carné para entrar". El 500 es "algo explotó adentro".
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">En Laravel: verbos → métodos del Controller</div>
    <div class="code-block">
      <div class="code-hdr"><span>routes/api.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">use</span> <span class="cls">App\Http\Controllers\Api\ClienteController</span>;

<span class="cm">// Route::apiResource hace esto automáticamente:</span>
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/clientes'</span>,        [<span class="cls">ClienteController</span>::class, <span class="str">'index'</span>]);
<span class="cls">Route</span>::<span class="fn">post</span>(<span class="str">'/clientes'</span>,       [<span class="cls">ClienteController</span>::class, <span class="str">'store'</span>]);
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/clientes/{id}'</span>,  [<span class="cls">ClienteController</span>::class, <span class="str">'show'</span>]);
<span class="cls">Route</span>::<span class="fn">patch</span>(<span class="str">'/clientes/{id}'</span>,[<span class="cls">ClienteController</span>::class, <span class="str">'update'</span>]);
<span class="cls">Route</span>::<span class="fn">delete</span>(<span class="str">'/clientes/{id}'</span>,[<span class="cls">ClienteController</span>::class, <span class="str">'destroy'</span>]);

<span class="cm">// Equivale a una sola línea:</span>
<span class="cls">Route</span>::<span class="fn">apiResource</span>(<span class="str">'clientes'</span>, <span class="cls">ClienteController</span>::class);</code></pre>
    </div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Checkpoint</div>
    <div class="deliv-title">Debes poder responder</div>
    <ul>
      <li>¿Qué verbo uso para crear un cliente nuevo?</li>
      <li>¿Qué status code devuelvo cuando creo algo exitosamente?</li>
      <li>Si el cliente con ID 99 no existe, ¿qué status devuelvo?</li>
      <li>¿Qué hace Route::apiResource?</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-c2" onclick="markDone('c2')">✓ Concepto entendido</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('c1',document.getElementById('nav-c1'))">← Concepto 1</button>
    <span class="pg-ind">C2 / 7</span>
    <button class="pg-btn" onclick="show('p1',document.getElementById('nav-p1'))">Práctica 1 →</button>
  </div>
</div>

<!-- ══ P1: CREAR PROYECTO ══ -->
<div class="page" id="page-p1">
  <div class="phase-hdr">
    <div class="phase-tag">Práctica 01 · 10 min · Terminal</div>
    <h2 class="phase-title">Crear el proyecto<br>api-practica</h2>
    <div class="phase-goal"><strong>Meta:</strong> Un proyecto Laravel nuevo corriendo en local. Sin Breeze, sin complicaciones. Solo el esqueleto limpio para construir una API.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 1 — Crear con Laravel Herd</div>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">PowerShell / Terminal</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">laravel new api-practica</span></div>
      </div>
    </div>
    <div class="concept">
      <div class="concept-title">Opciones del instalador — selecciona estas</div>
      <div class="concept-body">
        <table class="tbl" style="margin-top:6px">
          <thead><tr><th>Pregunta</th><th>Respuesta</th></tr></thead>
          <tbody>
            <tr><td>Starter kit</td><td><strong style="color:var(--green)">No starter kit</strong> — no necesitamos Breeze ni Blade</td></tr>
            <tr><td>Testing</td><td>PHPUnit</td></tr>
            <tr><td>Database</td><td><strong style="color:var(--green)">SQLite</strong> — más simple para practicar</td></tr>
            <tr><td>Run migrations</td><td>Yes</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 2 — Abrir en WebStorm y verificar</div>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">cd api-practica</span></div>
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan serve</span></div>
      </div>
    </div>
    <div class="info note"><div class="info-lbl">Verificar</div>Abre <code>http://localhost:8000</code> en el navegador. Debes ver la página de bienvenida de Laravel. Si la ves, el proyecto está listo.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 3 — Revisar api.php</div>
    <p style="font-size:13px;color:var(--text2);margin-bottom:12px">Abre <code>routes/api.php</code>. En Laravel 11/12 puede que no exista todavía. Si no está, créalo con:</p>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan install:api</span></div>
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan migrate</span></div>
      </div>
    </div>
    <div class="info tip"><div class="info-lbl">¿Qué hace install:api?</div>Crea <code>routes/api.php</code>, instala Sanctum para tokens de autenticación, y registra la tabla <code>personal_access_tokens</code>.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Estructura que debes ver</div>
    <div class="tree">
<span class="td">api-practica/</span>
├── <span class="td">app/</span>
│   └── <span class="td">Http/Controllers/</span>   <span class="tc">← aquí vivirán tus controllers</span>
├── <span class="td">database/</span>
│   └── <span class="td">migrations/</span>          <span class="tc">← migraciones de tablas</span>
├── <span class="td">routes/</span>
│   ├── <span class="tf">web.php</span>              <span class="tc">← rutas HTML (no tocaremos)</span>
│   └── <span class="tn">api.php</span>              <span class="tc">← aquí van las rutas de la API ←</span>
└── <span class="tf">.env</span>                     <span class="tc">← DB_CONNECTION=sqlite</span>
    </div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Entregable</div>
    <div class="deliv-title">Proyecto corriendo en local</div>
    <ul>
      <li>php artisan serve corriendo sin errores</li>
      <li>Página de bienvenida visible en localhost:8000</li>
      <li>routes/api.php existe en el proyecto</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-p1" onclick="markDone('p1')">✓ Marcar como completado</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('c2',document.getElementById('nav-c2'))">← Concepto 2</button>
    <span class="pg-ind">P1 / 7</span>
    <button class="pg-btn" onclick="show('p2',document.getElementById('nav-p2'))">Práctica 2 →</button>
  </div>
</div>

<!-- ══ P2: PRIMERA RUTA ══ -->
<div class="page" id="page-p2">
  <div class="phase-hdr">
    <div class="phase-tag">Práctica 02 · 15 min · Live coding</div>
    <h2 class="phase-title">Primera ruta que<br>devuelve JSON</h2>
    <div class="phase-goal"><strong>Meta:</strong> El "Hola mundo" de las APIs. Una ruta en <code>api.php</code> que responde JSON real que puedas ver desde el HTTP Client.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 1 — La ruta más simple posible</div>
    <p style="font-size:13px;color:var(--text2);margin-bottom:12px">Abre <code>routes/api.php</code> y escribe esto:</p>
    <div class="code-block">
      <div class="code-hdr"><span>routes/api.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">use</span> <span class="cls">Illuminate\Http\Request</span>;
<span class="kw">use</span> <span class="cls">Illuminate\Support\Facades\Route</span>;

<span class="cm">// Hola mundo de la API</span>
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/hola'</span>, <span class="kw">function</span> () {
    <span class="kw">return</span> response()-><span class="fn">json</span>([
        <span class="str">'mensaje'</span> => <span class="str">'Hola desde la API'</span>,
        <span class="str">'version'</span> => <span class="str">'1.0'</span>,
        <span class="str">'timestamp'</span> => now()-><span class="fn">toISOString</span>(),
    ]);
});

<span class="cm">// Ruta con parámetro</span>
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/saludo/{nombre}'</span>, <span class="kw">function</span> (<span class="kw">string</span> $nombre) {
    <span class="kw">return</span> response()-><span class="fn">json</span>([
        <span class="str">'mensaje'</span> => <span class="str">"Hola, $nombre! Bienvenido a la API"</span>,
    ]);
});</code></pre>
    </div>

    <div class="info note"><div class="info-lbl">¿Por qué response()->json() y no return []?</div>Puedes hacer <code>return []</code> y Laravel lo convierte a JSON. Pero con <code>response()->json()</code> puedes controlar el status code: <code>response()->json($data, 201)</code>. Usa siempre la forma explícita.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 2 — Verificar en el navegador primero</div>
    <div class="steps">
      <div class="step">
        <div class="sn">1</div>
        <div class="sc">
          <div class="st">Abre esta URL en el navegador</div>
          <div class="sb"><code>http://localhost:8000/api/hola</code> — debes ver el JSON directamente. Nota que la URL tiene el prefijo <code>/api</code> automáticamente.</div>
        </div>
      </div>
      <div class="step">
        <div class="sn">2</div>
        <div class="sc">
          <div class="st">Prueba con parámetro</div>
          <div class="sb"><code>http://localhost:8000/api/saludo/James</code> — cambia "James" por tu nombre.</div>
        </div>
      </div>
    </div>
    <div class="info tip" style="margin-top:12px"><div class="info-lbl">¿Por qué el prefijo /api?</div>Laravel registra <code>api.php</code> con el prefijo <code>/api</code> automáticamente en <code>bootstrap/app.php</code>. Todo lo que escribas en <code>api.php</code> queda en <code>/api/tu-ruta</code>.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 3 — Probar en el HTTP Client de JetBrains</div>
    <div class="info note"><div class="info-lbl">Crear archivo .http</div>En WebStorm/PhpStorm: clic derecho en el proyecto → New → File → escribe <code>http/prueba.http</code>. Eso crea la carpeta y el archivo.</div>
    <div class="code-block">
      <div class="code-hdr"><span>http/prueba.http <span class="code-lang">· HTTP Client</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="cm">### Hola mundo de la API</span>
<span class="http-get">GET</span> http://localhost:8000/api/hola
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### Ruta con parámetro</span>
<span class="http-get">GET</span> http://localhost:8000/api/saludo/James
<span class="http-hdr">Accept</span>: application/json</code></pre>
    </div>
    <div class="steps">
      <div class="step">
        <div class="sn">1</div>
        <div class="sc">
          <div class="st">Haz clic en el triángulo ▶ verde junto a la primera línea GET</div>
          <div class="sb">Se abre el panel de respuesta a la derecha. Debes ver el JSON con status <span class="tag tag-g">200</span>.</div>
        </div>
      </div>
      <div class="step">
        <div class="sn">2</div>
        <div class="sc">
          <div class="st">Observa la respuesta completa</div>
          <div class="sb">El HTTP Client muestra: status code, headers de respuesta, y el body JSON formateado. El panel de endpoints a la derecha también lista tus rutas.</div>
        </div>
      </div>
    </div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Entregable</div>
    <div class="deliv-title">Dos rutas GET funcionando</div>
    <ul>
      <li>GET /api/hola devuelve JSON con mensaje, versión y timestamp</li>
      <li>GET /api/saludo/{nombre} devuelve saludo personalizado</li>
      <li>Archivo http/prueba.http en el proyecto con las dos peticiones</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-p2" onclick="markDone('p2')">✓ Marcar como completado</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('p1',document.getElementById('nav-p1'))">← Práctica 1</button>
    <span class="pg-ind">P2 / 7</span>
    <button class="pg-btn" onclick="show('p3',document.getElementById('nav-p3'))">Práctica 3 →</button>
  </div>
</div>

<!-- ══ P3: MODELO + CONTROLLER ══ -->
<div class="page" id="page-p3">
  <div class="phase-hdr">
    <div class="phase-tag">Práctica 03 · 20 min · Live coding</div>
    <h2 class="phase-title">Modelo + Controller<br>+ Migración</h2>
    <div class="phase-goal"><strong>Meta:</strong> Crear el modelo <code>Cliente</code> con su tabla en la base de datos y el controlador API que lo maneja. Base de todo el CRUD.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 1 — Crear todo con un solo comando</div>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan make:model Cliente -m</span></div>
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan make:controller Api/ClienteController --api --model=Cliente</span></div>
      </div>
    </div>
    <div class="concept">
      <div class="concept-title">¿Qué significan esas flags?</div>
      <div class="concept-body">
        <table class="tbl" style="margin-top:6px">
          <thead><tr><th>Flag</th><th>Qué crea</th></tr></thead>
          <tbody>
            <tr><td><code>-m</code></td><td>La migración junto con el modelo</td></tr>
            <tr><td><code>--api</code></td><td>Controller sin métodos <code>create()</code> y <code>edit()</code> (son para vistas Blade)</td></tr>
            <tr><td><code>--model=Cliente</code></td><td>Ya tipea el modelo en los métodos del controller</td></tr>
            <tr><td><code>Api/ClienteController</code></td><td>Crea el controller dentro de la carpeta <code>Api/</code></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 2 — Definir la migración</div>
    <p style="font-size:13px;color:var(--text2);margin-bottom:12px">Abre el archivo en <code>database/migrations/..._create_clientes_table.php</code>:</p>
    <div class="code-block">
      <div class="code-hdr"><span>database/migrations/create_clientes_table.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">public function</span> <span class="fn">up</span>(): <span class="kw">void</span>
{
    <span class="cls">Schema</span>::<span class="fn">create</span>(<span class="str">'clientes'</span>, <span class="kw">function</span> (<span class="cls">Blueprint</span> $table) {
        $table-><span class="fn">id</span>();
        $table-><span class="fn">string</span>(<span class="str">'nombre'</span>);
        $table-><span class="fn">string</span>(<span class="str">'email'</span>)-><span class="fn">unique</span>();
        $table-><span class="fn">string</span>(<span class="str">'telefono'</span>)-><span class="fn">nullable</span>();
        $table-><span class="fn">string</span>(<span class="str">'ciudad'</span>)-><span class="fn">default</span>(<span class="str">'Medellín'</span>);
        $table-><span class="fn">boolean</span>(<span class="str">'activo'</span>)-><span class="fn">default</span>(<span class="kw">true</span>);
        $table-><span class="fn">timestamps</span>();
    });
}</code></pre>
    </div>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan migrate</span></div>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 3 — Configurar el Modelo</div>
    <div class="code-block">
      <div class="code-hdr"><span>app/Models/Cliente.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">class</span> <span class="cls">Cliente</span> <span class="kw">extends</span> <span class="cls">Model</span>
{
    <span class="kw">use</span> <span class="cls">HasFactory</span>;

    <span class="kw">protected</span> $fillable = [
        <span class="str">'nombre'</span>,
        <span class="str">'email'</span>,
        <span class="str">'telefono'</span>,
        <span class="str">'ciudad'</span>,
        <span class="str">'activo'</span>,
    ];

    <span class="kw">protected</span> $casts = [
        <span class="str">'activo'</span> => <span class="str">'boolean'</span>,
    ];
}</code></pre>
    </div>
    <div class="info warn"><div class="info-lbl">Importante — $fillable</div>Sin <code>$fillable</code>, Laravel bloquea la asignación masiva (<code>MassAssignmentException</code>). Debes declarar explícitamente qué campos puede recibir del exterior.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 4 — Registrar la ruta en api.php</div>
    <div class="code-block">
      <div class="code-hdr"><span>routes/api.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">use</span> <span class="cls">App\Http\Controllers\Api\ClienteController</span>;

<span class="cm">// Una sola línea crea las 5 rutas del CRUD</span>
<span class="cls">Route</span>::<span class="fn">apiResource</span>(<span class="str">'clientes'</span>, <span class="cls">ClienteController</span>::class);</code></pre>
    </div>
    <div class="bash">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal — Verificar rutas</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan route:list --path=clientes</span></div>
      </div>
    </div>
    <div class="info tip"><div class="info-lbl">Debes ver 5 rutas</div>GET /api/clientes · POST /api/clientes · GET /api/clientes/{cliente} · PATCH/PUT /api/clientes/{cliente} · DELETE /api/clientes/{cliente}</div>
  </div>

  <div class="sec">
    <div class="sec-title">Estructura generada</div>
    <div class="tree">
<span class="td">app/</span>
├── <span class="td">Http/Controllers/</span>
│   └── <span class="tn">Api/ClienteController.php</span>  <span class="tc">← controller API sin create/edit</span>
└── <span class="td">Models/</span>
    └── <span class="tn">Cliente.php</span>               <span class="tc">← modelo con $fillable y $casts</span>

<span class="td">database/migrations/</span>
└── <span class="tn">..._create_clientes_table.php</span>

<span class="td">routes/</span>
└── <span class="tf">api.php</span>                        <span class="tc">← Route::apiResource('clientes',...)</span>
    </div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Entregable</div>
    <div class="deliv-title">Modelo + tabla + rutas registradas</div>
    <ul>
      <li>Modelo Cliente con $fillable y $casts configurados</li>
      <li>Tabla clientes creada (php artisan migrate corrió ok)</li>
      <li>5 rutas visibles en php artisan route:list</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-p3" onclick="markDone('p3')">✓ Marcar como completado</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('p2',document.getElementById('nav-p2'))">← Práctica 2</button>
    <span class="pg-ind">P3 / 7</span>
    <button class="pg-btn" onclick="show('p4',document.getElementById('nav-p4'))">Práctica 4 →</button>
  </div>
</div>

<!-- ══ P4: HTTP CLIENT ══ -->
<div class="page" id="page-p4">
  <div class="phase-hdr">
    <div class="phase-tag">Práctica 04 · 15 min · HTTP Client</div>
    <h2 class="phase-title">Probar con el<br>HTTP Client de JetBrains</h2>
    <div class="phase-goal"><strong>Meta:</strong> Crear el archivo <code>.http</code> del proyecto y probar el GET de clientes. Entender cómo leer la respuesta en el panel del IDE.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 1 — Crear el archivo de peticiones</div>
    <div class="steps">
      <div class="step">
        <div class="sn">1</div>
        <div class="sc">
          <div class="st">Crea la carpeta http/ en la raíz del proyecto</div>
          <div class="sb">Clic derecho en el proyecto en el panel de archivos → New → Directory → escribe <code>http</code></div>
        </div>
      </div>
      <div class="step">
        <div class="sn">2</div>
        <div class="sc">
          <div class="st">Crea el archivo clientes.http dentro de esa carpeta</div>
          <div class="sb">Clic derecho en la carpeta <code>http/</code> → New → File → <code>clientes.http</code></div>
        </div>
      </div>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 2 — Escribir las peticiones de prueba</div>
    <div class="code-block">
      <div class="code-hdr"><span>http/clientes.http <span class="code-lang">· HTTP Client</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="cm">### Listar todos los clientes</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### Ver un cliente específico</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes/1
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### Ver cliente que no existe → debe dar 404</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes/9999
<span class="http-hdr">Accept</span>: application/json</code></pre>
    </div>

    <div class="info note"><div class="info-lbl">¿Por qué ### (triple hash)?</div>En los archivos .http, <code>###</code> separa cada petición. Sin ese separador, el HTTP Client no sabe dónde termina una petición y empieza la siguiente. Es obligatorio entre peticiones.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Paso 3 — Ejecutar y leer la respuesta</div>
    <div class="steps">
      <div class="step">
        <div class="sn">1</div>
        <div class="sc">
          <div class="st">Haz clic en ▶ junto a la primera petición GET</div>
          <div class="sb">La respuesta aparece en el panel derecho. Por ahora verás <code>{"data": []}</code> porque la tabla está vacía. Eso es <strong>correcto</strong> — el endpoint funciona.</div>
        </div>
      </div>
      <div class="step">
        <div class="sn">2</div>
        <div class="sc">
          <div class="st">Verifica el GET /clientes/9999</div>
          <div class="sb">Debe responder <span class="tag tag-r">404</span>. Laravel usa Route Model Binding — si el ID no existe en la tabla, devuelve 404 automáticamente.</div>
        </div>
      </div>
      <div class="step">
        <div class="sn">3</div>
        <div class="sc">
          <div class="st">Agrega un cliente directo en Tinker para probar</div>
          <div class="sb">Abre otra terminal y ejecuta el comando de abajo para tener datos.</div>
        </div>
      </div>
    </div>
    <div class="bash" style="margin-top:12px">
      <div class="bash-hdr">
        <div class="dot" style="background:#ff5f57"></div>
        <div class="dot" style="background:#febc2e"></div>
        <div class="dot" style="background:#28c840"></div>
        <span style="margin-left:8px">Terminal — Tinker</span>
      </div>
      <div class="bash-body">
        <div class="bash-line"><span class="prompt">$</span><span class="cmd">php artisan tinker</span></div>
        <div class="bash-line"><span class="prompt">>>></span><span class="cmd">App\Models\Cliente::create(['nombre'=>'Ana García','email'=>'ana@test.com','ciudad'=>'Medellín'])</span></div>
        <div class="bash-line"><span class="prompt">>>></span><span class="cmd">App\Models\Cliente::create(['nombre'=>'Luis Pérez','email'=>'luis@test.com','ciudad'=>'Bogotá'])</span></div>
      </div>
    </div>
    <div class="info tip" style="margin-top:10px"><div class="info-lbl">Ahora sí</div>Vuelve a ejecutar <code>GET /api/clientes</code> en el HTTP Client. Debes ver los dos clientes que acabas de crear en el JSON.</div>
  </div>

  <div class="sec">
    <div class="sec-title">El controller todavía tiene métodos vacíos</div>
    <p style="font-size:13px;color:var(--text2);margin-bottom:12px">Abre <code>app/Http/Controllers/Api/ClienteController.php</code>. El método <code>index()</code> retorna vacío. Vamos a llenarlo:</p>
    <div class="code-block">
      <div class="code-hdr"><span>Api/ClienteController.php — método index() <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">public function</span> <span class="fn">index</span>(): <span class="cls">JsonResponse</span>
{
    $clientes = <span class="cls">Cliente</span>::<span class="fn">all</span>();

    <span class="kw">return</span> response()-><span class="fn">json</span>([
        <span class="str">'data'</span>  => $clientes,
        <span class="str">'total'</span> => $clientes-><span class="fn">count</span>(),
    ]);
}

<span class="kw">public function</span> <span class="fn">show</span>(<span class="cls">Cliente</span> $cliente): <span class="cls">JsonResponse</span>
{
    <span class="kw">return</span> response()-><span class="fn">json</span>($cliente);
}</code></pre>
    </div>
    <div class="info note"><div class="info-lbl">JsonResponse como tipo de retorno</div>Agrega <code>use Illuminate\Http\JsonResponse;</code> al inicio del archivo. Tipar el retorno como <code>JsonResponse</code> es buena práctica — el IDE te ayuda mejor y el código es más claro.</div>
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Entregable</div>
    <div class="deliv-title">HTTP Client funcionando con datos reales</div>
    <ul>
      <li>GET /api/clientes devuelve los dos clientes creados en Tinker</li>
      <li>GET /api/clientes/1 devuelve el primer cliente</li>
      <li>GET /api/clientes/9999 devuelve 404</li>
      <li>Archivo http/clientes.http en el proyecto</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-p4" onclick="markDone('p4')">✓ Marcar como completado</button>
  <div class="pager">
    <button class="pg-btn" onclick="show('p3',document.getElementById('nav-p3'))">← Práctica 3</button>
    <span class="pg-ind">P4 / 7</span>
    <button class="pg-btn" onclick="show('p5',document.getElementById('nav-p5'))">Práctica 5 →</button>
  </div>
</div>

<!-- ══ P5: CRUD COMPLETO ══ -->
<div class="page" id="page-p5">
  <div class="phase-hdr">
    <div class="phase-tag">Práctica 05 · 25 min · Live coding</div>
    <h2 class="phase-title">CRUD completo —<br>POST, PUT, DELETE</h2>
    <div class="phase-goal"><strong>Meta:</strong> Completar los métodos <code>store()</code>, <code>update()</code> y <code>destroy()</code> con validación y status codes correctos. Tu primera API 100% funcional.</div>
  </div>

  <div class="sec">
    <div class="sec-title">El controller completo</div>
    <div class="code-block">
      <div class="code-hdr"><span>app/Http/Controllers/Api/ClienteController.php <span class="code-lang">· PHP</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="kw">namespace</span> App\Http\Controllers\Api;

<span class="kw">use</span> <span class="cls">App\Http\Controllers\Controller</span>;
<span class="kw">use</span> <span class="cls">App\Models\Cliente</span>;
<span class="kw">use</span> <span class="cls">Illuminate\Http\JsonResponse</span>;
<span class="kw">use</span> <span class="cls">Illuminate\Http\Request</span>;

<span class="kw">class</span> <span class="cls">ClienteController</span> <span class="kw">extends</span> <span class="cls">Controller</span>
{
    <span class="kw">public function</span> <span class="fn">index</span>(): <span class="cls">JsonResponse</span>
    {
        <span class="kw">return</span> response()-><span class="fn">json</span>([
            <span class="str">'data'</span>  => <span class="cls">Cliente</span>::<span class="fn">all</span>(),
            <span class="str">'total'</span> => <span class="cls">Cliente</span>::<span class="fn">count</span>(),
        ]);
    }

    <span class="kw">public function</span> <span class="fn">store</span>(<span class="cls">Request</span> $request): <span class="cls">JsonResponse</span>
    {
        $data = $request-><span class="fn">validate</span>([
            <span class="str">'nombre'</span>   => [<span class="str">'required'</span>, <span class="str">'string'</span>, <span class="str">'max:120'</span>],
            <span class="str">'email'</span>    => [<span class="str">'required'</span>, <span class="str">'email'</span>, <span class="str">'unique:clientes'</span>],
            <span class="str">'telefono'</span> => [<span class="str">'nullable'</span>, <span class="str">'string'</span>],
            <span class="str">'ciudad'</span>   => [<span class="str">'nullable'</span>, <span class="str">'string'</span>],
        ]);

        $cliente = <span class="cls">Cliente</span>::<span class="fn">create</span>($data);

        <span class="kw">return</span> response()-><span class="fn">json</span>($cliente, <span class="num">201</span>); <span class="cm">// 201 = Created</span>
    }

    <span class="kw">public function</span> <span class="fn">show</span>(<span class="cls">Cliente</span> $cliente): <span class="cls">JsonResponse</span>
    {
        <span class="kw">return</span> response()-><span class="fn">json</span>($cliente);
    }

    <span class="kw">public function</span> <span class="fn">update</span>(<span class="cls">Request</span> $request, <span class="cls">Cliente</span> $cliente): <span class="cls">JsonResponse</span>
    {
        $data = $request-><span class="fn">validate</span>([
            <span class="str">'nombre'</span>   => [<span class="str">'sometimes'</span>, <span class="str">'string'</span>, <span class="str">'max:120'</span>],
            <span class="str">'email'</span>    => [<span class="str">'sometimes'</span>, <span class="str">'email'</span>, <span class="str">'unique:clientes,email,'</span>.$cliente->id],
            <span class="str">'telefono'</span> => [<span class="str">'nullable'</span>, <span class="str">'string'</span>],
            <span class="str">'ciudad'</span>   => [<span class="str">'nullable'</span>, <span class="str">'string'</span>],
            <span class="str">'activo'</span>   => [<span class="str">'sometimes'</span>, <span class="str">'boolean'</span>],
        ]);

        $cliente-><span class="fn">update</span>($data);

        <span class="kw">return</span> response()-><span class="fn">json</span>($cliente);
    }

    <span class="kw">public function</span> <span class="fn">destroy</span>(<span class="cls">Cliente</span> $cliente): <span class="cls">JsonResponse</span>
    {
        $cliente-><span class="fn">delete</span>();

        <span class="kw">return</span> response()-><span class="fn">json</span>([
            <span class="str">'message'</span> => <span class="str">'Cliente eliminado correctamente.'</span>,
        ]);
    }
}</code></pre>
    </div>

    <div class="concept">
      <div class="concept-title">Diferencia entre required y sometimes en validación</div>
      <div class="concept-body">
        <p><code>required</code> — el campo DEBE venir en el request. Si no viene, error 422.</p>
        <p><code>sometimes</code> — si el campo viene, se valida. Si no viene, se ignora. Perfecto para PATCH donde puedes enviar solo los campos que quieres cambiar.</p>
      </div>
    </div>

    <div class="info warn"><div class="info-lbl">unique en update — ojo con esto</div><code>'unique:clientes,email,'.$cliente->id</code> le dice a Laravel: "el email debe ser único en la tabla clientes, EXCEPTO para el registro con este ID". Sin ese ID, si mandas el mismo email del mismo cliente da error 422.</div>
  </div>

  <div class="sec">
    <div class="sec-title">Probar el CRUD completo en el HTTP Client</div>
    <div class="code-block">
      <div class="code-hdr"><span>http/clientes.http — versión completa <span class="code-lang">· HTTP Client</span></span><button class="copy-btn" onclick="copyCode(this)">copiar</button></div>
      <pre><code><span class="cm">### 1. Listar todos</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### 2. Crear un cliente nuevo → debe dar 201</span>
<span class="http-post">POST</span> http://localhost:8000/api/clientes
<span class="http-hdr">Content-Type</span>: application/json
<span class="http-hdr">Accept</span>: application/json

<span class="http-body-c">{
  "nombre": "María López",
  "email": "maria@test.com",
  "telefono": "3001234567",
  "ciudad": "Cali"
}</span>

<span class="cm">### 3. Crear con datos inválidos → debe dar 422</span>
<span class="http-post">POST</span> http://localhost:8000/api/clientes
<span class="http-hdr">Content-Type</span>: application/json
<span class="http-hdr">Accept</span>: application/json

<span class="http-body-c">{
  "nombre": "",
  "email": "esto-no-es-un-email"
}</span>

<span class="cm">### 4. Ver cliente creado</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes/3
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### 5. Actualizar solo la ciudad (PATCH parcial)</span>
<span class="http-put">PATCH</span> http://localhost:8000/api/clientes/3
<span class="http-hdr">Content-Type</span>: application/json
<span class="http-hdr">Accept</span>: application/json

<span class="http-body-c">{
  "ciudad": "Barranquilla"
}</span>

<span class="cm">### 6. Eliminar → debe dar 200 con mensaje</span>
<span class="http-del">DELETE</span> http://localhost:8000/api/clientes/3
<span class="http-hdr">Accept</span>: application/json

<span class="cm">### 7. Intentar ver el cliente eliminado → debe dar 404</span>
<span class="http-get">GET</span> http://localhost:8000/api/clientes/3
<span class="http-hdr">Accept</span>: application/json</code></pre>
    </div>
  </div>

  <div class="sec">
    <div class="sec-title">El flujo completo que acabas de construir</div>
    <div class="flow">
      <div class="fb g">HTTP Client<br><small>petición</small></div>
      <div class="fa">→</div>
      <div class="fb b">api.php<br><small>ruta</small></div>
      <div class="fa">→</div>
      <div class="fb o">Controller<br><small>lógica</small></div>
      <div class="fa">→</div>
      <div class="fb p">Modelo<br><small>BD</small></div>
      <div class="fa">→</div>
      <div class="fb g">JSON<br><small>respuesta</small></div>
    </div>
  </div>

  <div class="info tip">
    <div class="info-lbl">¿Qué viene después?</div>
    Ya tienes una API REST funcional. En la siguiente sesión vas a hacer exactamente esto mismo pero sobre tu proyecto Latiendita real — con autenticación Sanctum, API Resources para controlar qué campos expones, y la app Flet que la consume desde producción.
  </div>

  <div class="deliv">
    <div class="deliv-lbl">Entregable final de la sesión</div>
    <div class="deliv-title">API REST completa y funcionando</div>
    <ul>
      <li>CRUD completo: GET, POST, PATCH, DELETE sobre /api/clientes</li>
      <li>Validación activa — errores 422 con el detalle de qué falló</li>
      <li>Status codes correctos: 200, 201, 404, 422</li>
      <li>Archivo http/clientes.http con las 7 peticiones de prueba</li>
      <li>Route Model Binding — el 404 automático funciona</li>
    </ul>
  </div>
  <button class="done-btn" id="btn-p5" onclick="markDone('p5')">✓ ¡API completada!</button>

  <div style="background:var(--blue-bg);border:1px solid var(--blue-dim);border-radius:8px;padding:16px 20px;margin-top:20px">
    <div style="font-family:var(--mono);font-size:10px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px">Siguiente sesión</div>
    <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:4px">Latiendita API — el reto real</div>
    <div style="font-size:13px;color:var(--text2)">Agregas esta capa API a tu proyecto Latiendita en producción. Sanctum, API Resources, y la app Flet que consume tu propio dominio.</div>
  </div>

  <div class="pager">
    <button class="pg-btn" onclick="show('p4',document.getElementById('nav-p4'))">← Práctica 4</button>
    <span class="pg-ind">P5 / 7</span>
    <button class="pg-btn" disabled>Fin de la sesión 🎉</button>
  </div>
</div>

</main>
</div>

<script>
const STEPS=['c1','c2','p1','p2','p3','p4','p5'];
const done=new Set(JSON.parse(localStorage.getItem('api-practica-done')||'[]'));

function persist(){localStorage.setItem('api-practica-done',JSON.stringify([...done]));}

function updateProgress(){
  const n=done.size;
  document.getElementById('prog-text').textContent=n+' / 7';
  document.getElementById('prog-bar').style.width=(n/7*100)+'%';
  STEPS.forEach(id=>{
    const nav=document.getElementById('nav-'+id);
    if(!nav)return;
    if(done.has(id)){nav.classList.add('done');nav.querySelector('.nav-check').style.opacity='1';}
    else{nav.classList.remove('done');nav.querySelector('.nav-check').style.opacity='0';}
    const btn=document.getElementById('btn-'+id);
    if(btn&&done.has(id)){btn.classList.add('done');btn.textContent=id.startsWith('p5')?'✓ ¡API completada!':id.startsWith('c')?'✓ Concepto entendido':'✓ Completado';}
  });
}

function show(id,navEl){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('visible'));
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  document.getElementById('page-'+id).classList.add('visible');
  if(navEl)navEl.classList.add('active');
  document.querySelector('.main').scrollTo(0,0);
  window.scrollTo(0,0);
}

function markDone(id){
  done.add(id);persist();updateProgress();
  const btn=document.getElementById('btn-'+id);
  if(btn){btn.classList.add('done');}
}

function copyCode(btn){
  const pre=btn.closest('.code-block').querySelector('pre');
  navigator.clipboard.writeText(pre.innerText).then(()=>{
    btn.textContent='copiado ✓';btn.classList.add('ok');
    setTimeout(()=>{btn.textContent='copiar';btn.classList.remove('ok');},1800);
  });
}

updateProgress();
</script>
</body>
</html>
