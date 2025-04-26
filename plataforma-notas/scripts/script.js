// === Animación de cambio entre "Iniciar sesión" y "Registrarse" ===
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

// === Efecto al hacer hover en botones ===
document.querySelectorAll('.role-button, button').forEach(boton => {
  boton.addEventListener('mouseenter', () => {
    boton.style.transform = 'scale(1.05)';
  });
  boton.addEventListener('mouseleave', () => {
    boton.style.transform = 'scale(1)';
  });
});

// === Mostrar alerta si el login está incompleto ===
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
document.querySelectorAll('.menu-toggle').forEach(boton => {
  boton.addEventListener('click', () => {
    const submenu = boton.nextElementSibling;
    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
  });
});
