<!--
Footer layout para autenticación
Diseño limpio, información institucional y responsivo con TailwindCSS.
-->

<footer class="bg-gray-100 border-t border-gray-200 mt-10">
  <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-sm text-gray-600">
      <div class="text-center md:text-left">
        <h3 class="text-gray-800 font-semibold mb-2">Institución</h3>
        <p>Unidades Tecnológicas de Santander</p>
        <p class="mt-1">Bucaramanga, Santander</p>
        <div class="mt-4">
          <h3 class="text-gray-800 font-semibold mb-2">REDES SOCIALES</h3>
          <div class="flex justify-center md:justify-start space-x-4">
            <a href="https://www.facebook.com/UnidadesTecnologicasdeSantanderUTS/" class="text-gray-600 hover:text-gray-800">
              <span class="sr-only">Facebook</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="url(#a)" height="40" width="40"><defs><linearGradient x1="50%" x2="50%" y1="97.078%" y2="0%" id="a"><stop offset="0%" stop-color="#0062E0"/><stop offset="100%" stop-color="#19AFFF"/></linearGradient></defs><path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"/><path fill="#FFF" d="m25 23 .8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z"/></svg>
            </a>
            <a href="https://x.com/Unidades_UTS" class="text-gray-600 hover:text-gray-800">
              <span class="sr-only">Twitter</span>
              <svg width="40" height="40" viewBox="0 0 1200 1227" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z" fill="black"/>
              </svg>
            </a>
            <a href="https://www.youtube.com/channel/UC-rIi4OnN0R10Wp-cPiLcpQ" class="text-gray-600 hover:text-gray-800">
              <span class="sr-only">YouTube</span>
              <svg viewBox="0 0 256 180" width="40" height="40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid"><path d="M250.346 28.075A32.18 32.18 0 0 0 227.69 5.418C207.824 0 127.87 0 127.87 0S47.912.164 28.046 5.582A32.18 32.18 0 0 0 5.39 28.24c-6.009 35.298-8.34 89.084.165 122.97a32.18 32.18 0 0 0 22.656 22.657c19.866 5.418 99.822 5.418 99.822 5.418s79.955 0 99.82-5.418a32.18 32.18 0 0 0 22.657-22.657c6.338-35.348 8.291-89.1-.164-123.134Z" fill="red"/><path fill="#FFF" d="m102.421 128.06 66.328-38.418-66.328-38.418z"/></svg>
            </a>
            <a href="https://www.instagram.com/unidades_uts/" class="text-gray-600 hover:text-gray-800">
              <span class="sr-only">Instagram</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" preserveAspectRatio="xMidYMid" viewBox="0 0 256 256">
                <defs>
                  <radialGradient id="instagramGradient" cx="19%" cy="78%" r="90%">
                    <stop offset="0%" style="stop-color:#FFDD55"/>
                    <stop offset="25%" style="stop-color:#FFDD55"/>
                    <stop offset="50%" style="stop-color:#FF543E"/>
                    <stop offset="75%" style="stop-color:#C837AB"/>
                    <stop offset="100%" style="stop-color:#8134AF"/>
                  </radialGradient>
                </defs>
                <path fill="url(#instagramGradient)" d="M128 23.064c34.177 0 38.225.13 51.722.745 12.48.57 19.258 2.655 23.769 4.408 5.974 2.322 10.238 5.096 14.717 9.575 4.48 4.479 7.253 8.743 9.575 14.717 1.753 4.511 3.838 11.289 4.408 23.768.615 13.498.745 17.546.745 51.723 0 34.178-.13 38.226-.745 51.723-.57 12.48-2.655 19.257-4.408 23.768-2.322 5.974-5.096 10.239-9.575 14.718-4.479 4.479-8.743 7.253-14.717 9.574-4.511 1.753-11.289 3.839-23.769 4.408-13.495.616-17.543.746-51.722.746-34.18 0-38.228-.13-51.723-.746-12.48-.57-19.257-2.655-23.768-4.408-5.974-2.321-10.239-5.095-14.718-9.574-4.479-4.48-7.253-8.744-9.574-14.718-1.753-4.51-3.839-11.288-4.408-23.768-.616-13.497-.746-17.545-.746-51.723 0-34.177.13-38.225.746-51.722.57-12.48 2.655-19.258 4.408-23.769 2.321-5.974 5.095-10.238 9.574-14.717 4.48-4.48 8.744-7.253 14.718-9.575 4.51-1.753 11.288-3.838 23.768-4.408 13.497-.615 17.545-.745 51.723-.745M128 0C93.237 0 88.878.147 75.226.77c-13.625.622-22.93 2.786-31.071 5.95-8.418 3.271-15.556 7.648-22.672 14.764C14.367 28.6 9.991 35.738 6.72 44.155 3.555 52.297 1.392 61.602.77 75.226.147 88.878 0 93.237 0 128c0 34.763.147 39.122.77 52.774.622 13.625 2.785 22.93 5.95 31.071 3.27 8.417 7.647 15.556 14.763 22.672 7.116 7.116 14.254 11.492 22.672 14.763 8.142 3.165 17.446 5.328 31.07 5.95 13.653.623 18.012.77 52.775.77s39.122-.147 52.774-.77c13.624-.622 22.929-2.785 31.07-5.95 8.418-3.27 15.556-7.647 22.672-14.763 7.116-7.116 11.493-14.254 14.764-22.672 3.164-8.142 5.328-17.446 5.95-31.07.623-13.653.77-18.012.77-52.775s-.147-39.122-.77-52.774c-.622-13.624-2.786-22.929-5.95-31.07-3.271-8.418-7.648-15.556-14.764-22.672C227.4 14.368 220.262 9.99 211.845 6.72c-8.142-3.164-17.447-5.328-31.071-5.95C167.122.147 162.763 0 128 0Zm0 62.27C91.698 62.27 62.27 91.7 62.27 128c0 36.302 29.428 65.73 65.73 65.73 36.301 0 65.73-29.428 65.73-65.73 0-36.301-29.429-65.73-65.73-65.73Zm0 108.397c-23.564 0-42.667-19.103-42.667-42.667S104.436 85.333 128 85.333s42.667 19.103 42.667 42.667-19.103 42.667-42.667 42.667Zm83.686-110.994c0 8.484-6.876 15.36-15.36 15.36-8.483 0-15.36-6.876-15.36-15.36 0-8.483 6.877-15.36 15.36-15.36 8.484 0 15.36 6.877 15.36 15.36Z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="text-center md:text-center">
        <h3 class="text-gray-800 font-semibold mb-2">Contacto</h3>
        <p>Email: peticiones@correo.uts.edu.co</p>
        <p class="mt-1">Correo físico: Calle de los Estudiantes #9-82, Ciudadela Real de Minas, Bucaramanga, Santander</p>
        <p class="mt-1">Línea de Atención a la Ciudadanía: PBX +57 607 6917700</p>
        <p class="mt-1">Atención y orientación: Edificio B-Piso 1- Oficina de Atención al Ciudadano.</p>
      </div>
      <div class="text-center md:text-right">
        <h3 class="text-gray-800 font-semibold mb-2">Desarrollado por</h3>
        <p>Centro de Innovación y Productividad - CIP</p>
        <p class="mt-1">Josué David Hernández Zorro</p>
      </div>
    </div>
    <div class="mt-6 border-t border-gray-200 pt-6 text-center">
      <p>&copy; <?= date('Y') ?> UTSeventos - para la gestión de eventos académicos y administrativos. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>
