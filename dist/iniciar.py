import tkinter as tk
from tkinter import messagebox
import subprocess
import os

def iniciar_proyecto():
    ruta_bat = r'C:\Users\angam\OneDrive\Escritorio\IniciarProyecto.bat'  # Cambia esta ruta si tu .bat está en otro lugar
    if os.path.exists(ruta_bat):
        # Ejecuta el archivo .bat sin mostrar consola adicional (usa shell=True)
        subprocess.Popen(['cmd', '/c', ruta_bat], shell=True)
    else:
        messagebox.showerror("Error", f"No se encontró el archivo:\n{ruta_bat}")

root = tk.Tk()
root.withdraw()  # Oculta ventana principal

respuesta = messagebox.askyesno("Iniciar Proyecto", "¿Quieres iniciar el proyecto?")

if respuesta:
    iniciar_proyecto()

root.destroy()
