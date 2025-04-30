# Plataforma Notas

## Descripción
Plataforma escolar diseñada para facilitar la gestión académica de estudiantes y profesores. Permite realizar tareas como el registro de usuarios, asignación de roles, subida de notas y consulta de resultados académicos.

## Tecnologías Utilizadas
- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript
- **Base de Datos**: MySQL
- **Servidor Local**: XAMPP

## Instalación
Sigue estos pasos para instalar y ejecutar el proyecto en tu entorno local:
1. **Clona este repositorio** en el directorio `htdocs` de XAMPP:
   ```bash
   git clone https://github.com/tu-repositorio/plataforma_notas.git
   ```
2. **Cofigura la base de datos**:
   - Abre phpMyAdmin o tu herramienta de gestión de bases de datos.
   - Crea una base de datos llamada `plataforma_notas`.
   - Importa el archivo SQL ubicado en `DB/plataforma_notas.sql`.

3. **Configura el archivo de conexión**:
   - Asegúrate de que el archivo `includes/conexion.php` esta configurado correctamente con las credenciales de tu base de datos:
     ```php
     $host = '127.0.0.1';
     $db   = 'plataforma_notas';
     $user = 'root';
     $pass = '';
     ```
4. **Inicia el servidor local**:
   - Abre el panel de cotrol XAMPP y asegúrate de que los servicios **Apache** y **MySQL** estén en ejecución.

5. **Accede al proyecto**:
   - Abre tu navegador y ve a:
     ```
     http://localhost/PROYECTO_DE_AULA/plataforma-notas/
     ```

## Estructura del Proyecto
```
PROYECTO_DE_AULA/
├── assets/
│   ├── styles/
│   │   └── styles.css
│   ├── scripts/
│   │   └── script.js
│   └── images/
├── controllers/
│   ├── procesar-login.php
│   ├── procesar-registro.php
│   └── ...
├── includes/
│   ├── conexion.php
│   └── test-conexion.php
├── pages/
│   ├── admin/
│   │   ├── gestion_usuarios/
│   │   │   ├── registro.php
│   │   │   ├── ver_usuarios.php
│   │   │   ├── cambiar_roles.php
│   │   │   └── eliminar_usuarios.php
│   │   ├── gestion_academica/
│   │   │   ├── historial_academico.php
│   │   │   └── ver_actividades.php
│   │   └── estadisticas/
│   │       ├── panel_general.php
│   │       └── actividad_reciente.php
│   ├── dashboard-admin.php
│   ├── dashboard-profesor.php
│   └── dashboard-estudiante.php
├── DB/
│   └── plataforma_notas.sql
|── login.php
|── logout.php

## Funcionalidades por Rol

### Administrador
- Registrar nuevos usuarios y asignar roles.
- Listar usuarios registrados.
- Cambiar roles de usuarios.
- Eliminar usuarios.
- Consultar estadísticas generales y actividades recientes.

### Profesor
- Subir notas de estudiantes.
- Consultar actividades asignadas.
- Visualizar resultados académicos.

### Estudiante
- Consultar su historial académico.
- Visualizar sus notas y actividades asignadas.

## Seguridad
- **Protección CSRF**: Implementada en formularios para evitar ataques de falsificación de solicitudes.
- **Encriptación de Contraseñas**: Las contraseñas se almacenan en la base de datos utilizando `password_hash()`.

## Próximos Pasos
- Implementar un sistema de notificaciones para los usuarios.
- Agregar gráficos interactivos para las estadísticas utilizando librerías como Chart.js.
- Mejorar el diseño responsivo para dispositivos móviles.

## Contribuciones
Si deseas contribuir al proyecto, por favor sigue estos pasos:
1. Haz un fork del repositorio.
2. Crea una nueva rama para tu funcionalidad:
   ```bash
   git checkout -b nueva-funcionalidad
   ```
3. Realiza tus cambios y haz un commit:
   ```bash
   git commit -m "Descripción de los cambios"
   ```
4. Envía tus cambios al repositorio remoto:
   ```bash
   git push origin nueva-funcionalidad
   ```
5. Abre un Pull Request en GitHub.

## Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.