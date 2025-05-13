// === Cambio entre "Iniciar sesión" y "Registrarse" ===
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

// === Animación suave al hacer scroll en enlaces ===
document.querySelectorAll('a[href^="#"]').forEach(enlace => {
  enlace.addEventListener('click', function(e) {
    e.preventDefault();
    const destino = document.querySelector(this.getAttribute('href'));
    if (destino) {
      destino.scrollIntoView({ behavior: 'smooth' });
    }
  });
});

// === Efecto hover en botones ===
document.querySelectorAll('.role-button, button').forEach(boton => {
  boton.addEventListener('mouseenter', () => {
    boton.style.transform = 'scale(1.05)';
  });
  boton.addEventListener('mouseleave', () => {
    boton.style.transform = 'scale(1)';
  });
});

// === Validación básica del formulario de login ===
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', (e) => {
    const campos = form.querySelectorAll('input[required]');
    let valido = true;
    campos.forEach(campo => {
      if (campo.value.trim() === '') {
        valido = false;
      }
    });

    if (!valido) {
      e.preventDefault();
      alert("Por favor completa todos los campos.");
    }
  });
});

// === Mostrar/Ocultar contraseña ===
document.querySelectorAll('.toggle-password').forEach(icono => {
  icono.addEventListener('click', () => {
    const input = icono.previousElementSibling;
    const esVisible = input.type === 'text';
    input.type = esVisible ? 'password' : 'text';
    
    const icon = icono.querySelector('i');
    if (icon) {
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    }
  });
});

// === Efecto hover en botones ===
document.querySelectorAll('button').forEach(boton => {
  boton.addEventListener('mouseenter', () => {
    boton.style.transform = 'scale(1.05)';
  });
  boton.addEventListener('mouseleave', () => {
    boton.style.transform = 'scale(1)';
  });
});

// === Alternar submenús del sidebar (si aplica) ===
document.querySelectorAll('.menu-toggle').forEach(boton => {
  boton.addEventListener('click', () => {
    const submenu = boton.nextElementSibling;
    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
  });
});
