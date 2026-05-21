# 🎓 Sistema de Gestión de Cursos y Participantes (ASSM)

Este sistema es una solución integral desarrollada en **Laravel 11** diseñada para administrar el ciclo de vida completo de capacitaciones, desde la creación de cursos y subcursos hasta el registro de alumnos, control de pagos y emisión de reportes.

---

## 📋 Propósito del Sistema
El sistema centraliza la operación administrativa de una institución educativa o de capacitación, permitiendo un control riguroso sobre quiénes se inscriben, qué cursos toman, el estado de sus pagos y la documentación legal (STPS) necesaria.

---

## 🛠️ Funcionalidades Principales

### 1. Gestión Avanzada de Cursos
*   **Creación por Pasos**: Proceso guiado de 7 niveles para configurar un curso (Datos básicos, modalidad, redes sociales, materiales, evaluaciones, certificaciones STPS y plataformas externas).
*   **Jerarquía de Subcursos**: Capacidad de crear subcursos vinculados a un curso principal, ideal para diplomados o módulos seriados.
*   **Modalidades Flexibles**: Soporte para cursos Presenciales, Virtuales, Mixtos o Sin Fecha definida.
*   **Gestión Documental**: Control de enlaces a Drive para temarios, planeaciones, listas de asistencia y certificados.
*   **Cumplimiento STPS**: Seguimiento de formatos **DC-3** y **DC-5**, registro ante la STPS y fechas de certificación.

### 2. Administración de Participantes
*   **Perfil Completo**: Registro detallado de datos personales, académicos y laborales (Empresa, RFC, Puesto).
*   **Control de Pagos**: Seguimiento de estados: *Pagado, Pendiente, Anticipo o Cancelado*.
*   **Historial Académico**: Visualización de todos los cursos en los que un alumno se ha inscrito y su estatus en cada uno.
*   **Registro Externo**: Formulario público para que los alumnos se pre-inscriban de forma autónoma.

### 3. Seguridad y Control de Acceso
*   **Roles de Usuario**:
    *   **Programador/Administrador**: Acceso total, gestión de configuraciones y eliminaciones definitivas.
    *   **Mantenimiento**: Gestión operativa sin acceso a configuraciones críticas.
    *   **Operación**: Consultas y registros básicos, con restricciones en edición y borrado.
*   **Protección de Datos**: Validaciones estrictas de CURP (18 caracteres) y Teléfono (10 dígitos).
*   **Auditoría (Logs)**: Historial detallado de cada acción realizada (quién creó, editó o eliminó qué registro y cuándo).

### 4. Sistema de Papelera y Respaldo
*   **Borrados Seguros**: Los registros eliminados no desaparecen de inmediato; se mueven a una papelera independiente.
*   **Recuperación**: Posibilidad de restaurar cualquier registro enviado a la papelera por error.
*   **Confirmación Admin**: La eliminación permanente requiere contraseña de administrador, evitando pérdidas accidentales de información.

### 5. Reportes y Herramientas
*   **Exportación Masiva**: Generación de listas de asistencia y reportes en **Excel y CSV**.
*   **Documentación PDF**: Generación de fichas técnicas de participantes y detalles de cursos en formato PDF.
*   **Gestión de Archivos**: Explorador local para organizar carpetas y archivos del sistema.
*   **Branding Personalizado**: Capacidad de cambiar el logo y colores del sistema desde el panel de configuración.

---

## 💻 Especificaciones Técnicas
- **Framework**: Laravel 11 (Estructura moderna y segura).
- **Lenguaje**: PHP 8.2+.
- **Base de Datos**: MySQL con integridad referencial.
- **Frontend**: Bootstrap 5 (Responsive para móviles y tablets).
- **Iconografía**: FontAwesome 6 Pro.

---

## ⚙️ Instalación y Configuración
1.  **Requisitos**: Servidor con PHP 8.2 y Composer.
2.  **Configuración**:
    ```bash
    cp .env.example .env
    # Configurar DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```
3.  **Despliegue**:
    ```bash
    composer install
    php artisan migrate
    php artisan key:generate
    php artisan serve
    ```

---
*Versión de Documentación: Mayo 2026*
