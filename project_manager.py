import os
import subprocess
import webbrowser
from tkinter import Tk, Button, Label, messagebox

def start_project():
    try:
        # Cambiar al directorio del proyecto
        project_dir = r"C:\xampp\htdocs\Proyecto IDB\CursosyParticipantes"
        os.chdir(project_dir)

        # Iniciar XAMPP
        subprocess.Popen(["C:\\xampp\\xampp_start.exe"])

        # Esperar unos segundos
        os.system("timeout /t 5 >nul")

        # Iniciar Laravel (php artisan serve)
        subprocess.Popen(["cmd", "/k", "php artisan serve"], creationflags=subprocess.CREATE_NEW_CONSOLE)

        # Iniciar Node.js (npm run dev)
        subprocess.Popen(["cmd", "/k", "npm run dev"], creationflags=subprocess.CREATE_NEW_CONSOLE)

        # Abrir la URL del proyecto en el navegador
        webbrowser.open("http://127.0.0.1:8000/login")

        messagebox.showinfo("Éxito", "Proyecto iniciado correctamente.")
    except Exception as e:
        messagebox.showerror("Error", f"No se pudo iniciar el proyecto: {e}")

def stop_project():
    try:
        # Detener XAMPP
        subprocess.Popen(["C:\\xampp\\xampp_stop.exe"])

        # Detener Laravel (php artisan serve) y Node.js (npm run dev)
        os.system("taskkill /IM php.exe /F")
        os.system("taskkill /IM node.exe /F")

        messagebox.showinfo("Éxito", "Proyecto detenido correctamente.")
    except Exception as e:
        messagebox.showerror("Error", f"No se pudo detener el proyecto: {e}")

# Crear la interfaz gráfica
root = Tk()
root.title("Gestor de Proyecto")
root.geometry("300x200")

Label(root, text="Control del Proyecto", font=("Arial", 16)).pack(pady=10)

Button(root, text="Iniciar Proyecto", command=start_project, width=20, height=2).pack(pady=10)
Button(root, text="Detener Proyecto", command=stop_project, width=20, height=2).pack(pady=10)

root.mainloop()
