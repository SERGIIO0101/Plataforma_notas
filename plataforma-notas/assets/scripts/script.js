// === Alternar entre "Iniciar sesión" y "Registrarse" ===
const contenedor = document.getElementById('contenedor');
const registrarseBtn = document.getElementById('registrarse');
const iniciarSesionBtn = document.getElementById('iniciarSesion');

if (registrarseBtn && iniciarSesionBtn && contenedor) {
  registrarseBtn.addEventListener('click', () => {
    contenedor.classList.add("modo-registro");
  });

  iniciarSesionBtn.addEventListener('click', () => {
    contenedor.classList.remove("modo-registro");
  });
}

// === Animación suave al hacer scroll en enlaces internos ===
document.querySelectorAll('a[href^="#"]').forEach(enlace => {
  enlace.addEventListener('click', function (e) {
    e.preventDefault();
    const destino = document.querySelector(this.getAttribute('href'));
    if (destino) {
      destino.scrollIntoView({ behavior: 'smooth' });
    }
  });
});

// === Validación básica del formulario de login con mensaje inline ===
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', (e) => {
    const campos = form.querySelectorAll('input[required]');
    let valido = true;

    campos.forEach(campo => {
      if (campo.value.trim() === '') {
        valido = false;
        campo.classList.add('campo-error');
      } else {
        campo.classList.remove('campo-error');
      }
    });

    const mensaje = form.querySelector('.form-error-msg');
    if (!valido) {
      e.preventDefault();
      if (mensaje) {
        mensaje.textContent = "Por favor completa todos los campos obligatorios.";
      }
    } else if (mensaje) {
      mensaje.textContent = ""; // Limpiar mensaje si está todo bien
    }
  });
});

// === Mostrar/Ocultar contraseña ===
document.querySelectorAll('.toggle-password').forEach(icono => {
  icono.addEventListener('click', () => {
    const input = icono.closest('.campo-password').querySelector('input');
    const esVisible = input.type === 'text';
    input.type = esVisible ? 'password' : 'text';

    const icon = icono.querySelector('i');
    if (icon) {
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    }
  });
});

// === Alternar submenús del sidebar ===
document.querySelectorAll('.menu-toggle').forEach(boton => {
  boton.addEventListener('click', () => {
    const submenu = boton.nextElementSibling;
    submenu.classList.toggle('abierto');
  });
});
