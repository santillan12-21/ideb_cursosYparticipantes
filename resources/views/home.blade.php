@php
    // Obtener el logo desde la configuración
    $setting = \App\Models\Setting::first();
    $logoPath = $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('images/default-logo.png');
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tus enlaces a CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Inicio</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }
    header {
      background-color: #000;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      z-index: 10;
    }
    /* Se define tres secciones en el header */
    .header-left,
    .header-center,
    .header-right {
      display: flex;
      align-items: center;
    }
    .header-left {
      /* Contiene el logo */
    }
    .header-center {
      flex: 1;
      justify-content: center;
    }
    .header-right {
      gap: 10px;
    }
    .logo {
      width: 100px;
      height: auto;
      cursor: pointer;
    }
    .menu-icon {
      background: none;
      border: none;
      outline: none;
      font-size: 30px;
      color: white;
      cursor: pointer;
      /* Se mantienen solo las 3 barras blancas del ícono */
    }
    .user-info-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .user-info-group a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
    }
    .user-info-group a:hover {
      text-decoration: underline;
    }
    /* Estilos para el menú de usuario */
    .user-menu {
      position: relative;
      display: inline-block;
    }
    .user-menu-trigger {
      background: none;
      border: none;
      color: white;
      padding: 8px 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 1rem;
      transition: all 0.3s ease;
      border-radius: 4px;
    }
    .user-menu-trigger:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .user-menu-trigger i {
      transition: transform 0.3s ease;
    }
    .user-menu-trigger.active i {
      transform: rotate(180deg);
    }
    .user-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      background-color: white;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      min-width: 200px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px);
      transition: all 0.3s ease;
      z-index: 1001;
    }
    .user-dropdown.active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .user-info {
      padding: 16px;
      border-bottom: 1px solid #eee;
    }
    .user-name {
      font-weight: 600;
      color: #333;
      margin-bottom: 4px;
    }
    .user-role {
      font-size: 0.875rem;
      color: #666;
    }
    .btn-cerrar-sesion {
      width: calc(100% - 32px);
      margin: 8px 16px;
      padding: 8px 16px;
      background: linear-gradient(135deg, #ff4757, #ff6b81);
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-cerrar-sesion:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 71, 87, 0.2);
    }
    .config-icon {
      width: 80px;
      height: auto;
      cursor: pointer;
    }
    /* Sidebar en la izquierda sin líneas blancas */
    .sidebar {
      position: fixed;
      top: 60px;
      left: -250px;
      width: 250px;
      height: calc(100% - 60px);
      background-color: #000;
      color: white;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
      transition: left 0.3s ease;
      z-index: 5;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      font-size: 20px;
      margin-bottom: 15px;
    }
    .container {
      text-align: center;
      padding: 40px;
    }
    h1 {
      margin-bottom: 30px;
      font-size: 2em;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      justify-items: center;
    }
    /* Clase para ocultar elementos basado en el rol */
    .role-restricted {
      display: none;
    }
  </style>
</head>
<body>
  @php
    use Illuminate\Support\Facades\Auth;
    $userRole = auth()->user()->puesto ?? 'guest';
  @endphp

  <header>
    <div class="header-left">
      <a href="/Inicio">
        <img src="{{ $logoPath }}" alt="Logo de la aplicación" style="max-width: 150px;">
      </a>
    </div>
    <div class="header-center">
      <button class="menu-icon" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div class="header-right">
      @auth
      <div class="user-info-group">
        <a href="{{ route('profile') }}">Mi Perfil</a>
        <div class="user-menu">
          <button class="user-menu-trigger" id="userMenuTrigger">
            <i class="fas fa-user-circle"></i>
            <span class="user-name-display">{{ auth()->user()->name }}</span>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="user-dropdown" id="userDropdown">
            <div class="user-info">
              <div class="user-name">{{ auth()->user()->name }}</div>
              <div class="user-role">{{ ucfirst(auth()->user()->puesto) }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="btn-cerrar-sesion">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar Sesión</span>
              </button>
            </form>
          </div>
        </div>
      </div>
      @if(auth()->user()->puesto == 'Programador')
      <a href="{{ route('configuraciones.index') }}" id="config-link">
        <img src="{{ asset('images/imagenuerca2.png') }}" alt="Configuraciones" class="config-icon">
      </a>
      @endif
      @endauth
    </div>
  </header>

  <div class="sidebar" id="sidebar">
    <a>Truco XD</a>
    @if(auth()->user()->puesto != 'Mantenimiento')
    <a href="/users" class="menu-item" data-restricted="Operacion">Creación usuario</a>
    @endif
    <a href="/cursos">Cursos</a>
    <a href="/participantes">Participantes</a>
    @if(auth()->user()->puesto != 'Operacion')
    <a href="/registro">Registro de curso</a>
    @endif
    <a href="{{ route('ruta.archivos') }}" class="menu-item" data-restricted="Operacion">Ruta archivos</a>
    <a href="https://drive.google.com/drive/folders/1HRJ_UliysPgzUOm1_XvcLR4MSuAjdODD?usp=sharing" target="_blank" class="drive-link menu-item" data-restricted="Operacion">
      <i class="fab fa-google-drive"></i> Carpeta de Drive
    </a>
    <a href="/export-db" class="menu-item" data-restricted="Operacion">Exportar Base de Datos</a>
    <a href="#" onclick="selectFile()" class="sidebar-import-link menu-item" data-restricted="Operacion">
      Importar Base de Datos
    </a>
  </div>

  <div class="container">
    <h1>Bienvenido</h1>
    <div class="grid">
      <form id="importForm" action="{{ route('database.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
        @csrf
        <input type="file" id="databaseFile" name="database_file" accept=".sql" style="display: none;" required>
      </form>
    </div>
  </div>

  <!-- Formulario de logout oculto -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- Scripts originales con funciones adicionales para gestionar permisos -->
  <script>
    function selectFile() {
      const fileInput = document.getElementById('databaseFile');
      const form = document.getElementById('importForm');
      fileInput.click();
      fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
          form.submit();
        }
      });
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      if (sidebar.style.left === '0px') {
        sidebar.style.left = '-250px';
      } else {
        sidebar.style.left = '0px';
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      const userMenuTrigger = document.getElementById('userMenuTrigger');
      const userDropdown = document.getElementById('userDropdown');

      function toggleUserMenu(event) {
        event.stopPropagation();
        userMenuTrigger.classList.toggle('active');
        userDropdown.classList.toggle('active');
      }

      function closeUserMenu() {
        userMenuTrigger.classList.remove('active');
        userDropdown.classList.remove('active');
      }

      userMenuTrigger.addEventListener('click', toggleUserMenu);

      // Cierra el menú al hacer clic fuera
      document.addEventListener('click', function(event) {
        const isClickInside = userMenuTrigger.contains(event.target) || userDropdown.contains(event.target);
        if (!isClickInside) {
          closeUserMenu();
        }
      });

      // Evita que se cierre al hacer clic dentro
      userDropdown.addEventListener('click', function(event) {
        event.stopPropagation();
      });

      // Restricciones basadas en el rol
      applyRoleRestrictions();
    });

    function applyRoleRestrictions() {
      // Obtiene el rol del usuario del elemento en el DOM
      const userRoleElement = document.querySelector('.user-role');
      if (!userRoleElement) return;

      const userRole = userRoleElement.textContent.trim().toLowerCase();

      // Ocultar elementos restringidos para el rol de Operacion
      if (userRole === 'operacion') {
        const restrictedItems = document.querySelectorAll('.menu-item[data-restricted="Operacion"]');
        restrictedItems.forEach(item => {
          item.style.display = 'none';
        });
      }
    }
  </script>
</body>
</html>
