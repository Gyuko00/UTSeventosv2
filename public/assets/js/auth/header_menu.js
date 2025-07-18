/**
 * SCRIPT DE MENÚ HAMBURGUESA RESPONSIVO
 * 
 * Controla la funcionalidad del menú hamburguesa en dispositivos móviles
 * y pantallas pequeñas. Permite mostrar y ocultar el menú de navegación
 * mediante un botón toggle, mejorando la experiencia de usuario en
 * interfaces responsivas.
 * 
 * Funcionalidades incluidas:
 * - Toggle de visibilidad del menú mediante clases CSS
 * - Manejo de eventos de click en el botón hamburguesa
 * - Inicialización automática al cargar el DOM
 * - Compatibilidad con frameworks CSS como Tailwind o Bootstrap
 * 
 * Elementos requeridos:
 * - Botón con ID 'menu-toggle' (botón hamburguesa)
 * - Contenedor con ID 'menu' (menú de navegación)
 * - Clase CSS 'hidden' para ocultar/mostrar elementos
 * 
 */

document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");
    menuToggle.addEventListener("click", function () {
      if (menu.classList.contains("hidden")) {
        menu.classList.remove("hidden");
      } else {
        menu.classList.add("hidden");
      }
    });
  });
  