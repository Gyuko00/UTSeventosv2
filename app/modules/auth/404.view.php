<?php 

/**
 * Página 404 para errores de redirección o páginas sin acceso.
 */

?>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes wiggle {
    0%, 100% { transform: rotate(-3deg); }
    50% { transform: rotate(3deg); }
}
@keyframes glow {
    0% { filter: drop-shadow(0 0 5px rgba(201, 209, 48, 0.5)); }
    100% { filter: drop-shadow(0 0 15px rgba(201, 209, 48, 0.8)); }
}
.animate-float { animation: float 3s ease-in-out infinite; }
.animate-wiggle { animation: wiggle 1s ease-in-out infinite; }
.animate-glow { animation: glow 2s ease-in-out infinite alternate; }
.animate-bounce-slow { animation: bounce 2s infinite; }
.animate-pulse-slow { animation: pulse 3s ease-in-out infinite; }
.animate-spin-slow { animation: spin 8s linear infinite; }

.brand-green { color: #c9d130; }
.bg-brand-green { background-color: #c9d130; }
.bg-brand-green-light { background-color: #e8f0a3; }
.bg-brand-green-dark { background-color: #a3b829; }
.bg-brand-green-darker { background-color: #7d8f1f; }
.border-brand-green { border-color: #c9d130; }
.text-brand-green { color: #a3b829; }

.glass-effect {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(201, 209, 48, 0.2);
}

.gradient-brand {
    background: linear-gradient(135deg, #e8f0a3, #c9d130, #a3b829);
}

.text-gradient {
    background: linear-gradient(45deg, #7d8f1f, #c9d130, #e8f0a3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<!-- Partículas de fondo animadas -->
<div class="fixed inset-0 overflow-hidden pointer-events-none" style="z-index: 1;">
    <div class="absolute top-10 left-10 w-2 h-2 bg-brand-green rounded-full animate-pulse opacity-30"></div>
    <div class="absolute top-20 right-20 w-3 h-3 bg-brand-green-light rounded-full animate-bounce-slow opacity-40"></div>
    <div class="absolute top-40 left-1/4 w-1 h-1 bg-brand-green-dark rounded-full animate-ping opacity-50"></div>
    <div class="absolute bottom-20 right-10 w-2 h-2 bg-brand-green rounded-full animate-pulse-slow opacity-35"></div>
    <div class="absolute bottom-40 left-20 w-4 h-4 bg-brand-green-light rounded-full animate-float opacity-25"></div>
    <div class="absolute top-1/2 right-1/3 w-1 h-1 bg-brand-green-dark rounded-full animate-ping opacity-40"></div>
</div>

<div class="relative min-h-96">
    <!-- Círculos decorativos de fondo -->
    <div class="absolute -top-16 -left-16 w-32 h-32 bg-brand-green-light rounded-full opacity-10 animate-spin-slow"></div>
    <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-brand-green rounded-full opacity-5 animate-float"></div>
    <div class="absolute top-1/2 -left-8 w-16 h-16 bg-brand-green-dark rounded-full opacity-15 animate-pulse-slow"></div>

    <!-- Contenido principal -->
    <div class="relative glass-effect rounded-3xl p-8 md:p-12 shadow-2xl text-center">
        
        <!-- Números 404 con robot integrado -->
        <div class="mb-12 relative">
            <div class="flex justify-center items-center space-x-2 md:space-x-6">
                <!-- Primer 4 -->
                <div class="relative">
                    <span class="text-6xl sm:text-8xl md:text-9xl font-black text-brand-green opacity-20 animate-float">4</span>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-8 h-8 md:w-12 md:h-12 bg-brand-green rounded-full animate-bounce-slow opacity-60"></div>
                    </div>
                </div>

                <!-- 0 con Robot -->
                <div class="relative">
                    <span class="text-6xl sm:text-8xl md:text-9xl font-black text-brand-green opacity-20">0</span>
                    <!-- Robot SVG mejorado -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative animate-float">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 md:w-28 md:h-28 animate-glow" viewBox="0 0 120 140" fill="none">
                                <!-- Sombra del robot -->
                                <ellipse cx="60" cy="135" rx="25" ry="3" fill="#000" opacity="0.1"/>
                                
                                <!-- Antena con efecto brillante -->
                                <line x1="60" y1="25" x2="60" y2="15" stroke="#7d8f1f" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="60" cy="12" r="3" fill="#c9d130" class="animate-pulse"/>
                                
                                <!-- Cabeza del robot -->
                                <rect x="40" y="25" width="40" height="30" rx="12" fill="#c9d130" style="filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));"/>
                                
                                <!-- Ojos -->
                                <circle cx="50" cy="38" r="4" fill="white"/>
                                <circle cx="70" cy="38" r="4" fill="white"/>
                                <circle cx="50" cy="38" r="2" fill="#333"/>
                                <circle cx="70" cy="38" r="2" fill="#333"/>
                                
                                <!-- Boca sonriente -->
                                <path d="M52 45 Q60 50 68 45" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                                
                                <!-- Cuerpo principal -->
                                <rect x="35" y="58" width="50" height="45" rx="8" fill="#c9d130" style="filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));"/>
                                
                                <!-- Panel frontal con detalles -->
                                <rect x="43" y="66" width="34" height="20" rx="4" fill="white" stroke="#a3b829" stroke-width="2"/>
                                <circle cx="52" cy="76" r="2" fill="#c9d130" class="animate-pulse"/>
                                <circle cx="60" cy="76" r="2" fill="#a3b829" class="animate-pulse"/>
                                <circle cx="68" cy="76" r="2" fill="#7d8f1f" class="animate-pulse"/>
                                
                                <!-- Líneas decorativas -->
                                <line x1="43" y1="92" x2="77" y2="92" stroke="#a3b829" stroke-width="2" stroke-linecap="round"/>
                                <line x1="47" y1="97" x2="73" y2="97" stroke="#c9d130" stroke-width="1.5" stroke-linecap="round"/>
                                
                                <!-- Brazos -->
                                <rect x="22" y="65" width="10" height="20" rx="5" fill="#c9d130" class="animate-wiggle" style="filter: drop-shadow(1px 2px 3px rgba(0,0,0,0.2));"/>
                                <rect x="88" y="65" width="10" height="20" rx="5" fill="#c9d130" class="animate-wiggle" style="filter: drop-shadow(1px 2px 3px rgba(0,0,0,0.2));"/>
                                <circle cx="27" cy="75" r="3" fill="#7d8f1f"/>
                                <circle cx="93" cy="75" r="3" fill="#7d8f1f"/>
                                
                                <!-- Piernas -->
                                <rect x="45" y="105" width="10" height="18" rx="5" fill="#c9d130" style="filter: drop-shadow(1px 2px 3px rgba(0,0,0,0.2));"/>
                                <rect x="65" y="105" width="10" height="18" rx="5" fill="#c9d130" style="filter: drop-shadow(1px 2px 3px rgba(0,0,0,0.2));"/>
                                
                                <!-- Pies -->
                                <ellipse cx="50" cy="125" rx="8" ry="4" fill="#7d8f1f"/>
                                <ellipse cx="70" cy="125" rx="8" ry="4" fill="#7d8f1f"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Segundo 4 -->
                <div class="relative">
                    <span class="text-6xl sm:text-8xl md:text-9xl font-black text-brand-green opacity-20 animate-float" style="animation-delay: 1s">4</span>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-6 h-6 md:w-10 md:h-10 bg-brand-green-dark rounded-full animate-ping opacity-50"></div>
                    </div>
                </div>
            </div>

            <!-- Efectos de partículas alrededor del robot -->
            <div class="absolute top-10 left-1/2 w-1 h-1 bg-brand-green rounded-full animate-ping opacity-60"></div>
            <div class="absolute bottom-10 left-1/3 w-2 h-2 bg-brand-green-light rounded-full animate-bounce opacity-40"></div>
            <div class="absolute top-1/2 right-10 w-1 h-1 bg-brand-green-dark rounded-full animate-pulse opacity-50"></div>
        </div>

        <!-- Mensaje principal con efectos tipográficos -->
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-800 mb-6 leading-tight">
                <span class="text-gradient animate-pulse">
                    ¡Oops!
                </span>
                <br>
                <span class="text-gray-700">Página no encontrada</span>
            </h1>
            
            <div class="relative">
                <p class="text-lg sm:text-xl text-gray-600 mb-4 max-w-2xl mx-auto leading-relaxed">
                    Parece que nuestro robot explorador se ha perdido en el ciberespacio junto contigo.
                </p>
                <p class="text-base sm:text-lg text-gray-500 max-w-xl mx-auto">
                    No te preocupes, te ayudaremos a encontrar el camino de vuelta a casa.
                </p>
                
                <!-- Elementos decorativos del texto -->
                <div class="absolute -top-2 -right-2 w-3 h-3 bg-brand-green rounded-full animate-bounce opacity-30"></div>
                <div class="absolute -bottom-2 -left-2 w-2 h-2 bg-brand-green-light rounded-full animate-ping opacity-40"></div>
            </div>
        </div>

        <!-- Botones con efectos hover mejorados -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-10">
            <a href="<?php URL_PATH ?>/utseventos/public/auth/login" 
               class="group gradient-brand hover:bg-brand-green-dark text-white font-bold py-4 px-10 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl border-2 border-transparent hover:border-brand-green-light relative overflow-hidden">
                <!-- Efecto de brillo en hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -translate-x-full group-hover:translate-x-full transition-all duration-1000"></div>
                <span class="relative flex items-center justify-center gap-3">
                    🏠 Volver al Inicio
                </span>
            </a>
            
            <button onclick="window.history.back()" 
                    class="group bg-white hover:bg-brand-green-light text-brand-green border-3 border-brand-green hover:border-brand-green-dark font-bold py-4 px-10 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-md hover:shadow-xl relative overflow-hidden">
                <!-- Efecto de brillo en hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-yellow-100 to-transparent opacity-0 group-hover:opacity-30 transform translate-x-full group-hover:-translate-x-full transition-all duration-1000"></div>
                <span class="relative flex items-center justify-center gap-3">
                    ⬅️ Página Anterior
                </span>
            </button>
        </div>

        <!-- Elementos decorativos inferiores -->
        <div class="relative">
            <!-- Línea decorativa ondulada -->
            <div class="w-full h-1 bg-gradient-to-r from-transparent via-brand-green to-transparent rounded-full mb-8 opacity-30"></div>
            
            <!-- Circuitos decorativos -->
            <div class="flex justify-center items-center space-x-4 mb-6">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-brand-green rounded-full animate-pulse"></div>
                    <div class="w-8 h-0.5 bg-brand-green-light opacity-50"></div>
                    <div class="w-2 h-2 bg-brand-green-dark rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                    <div class="w-6 h-0.5 bg-brand-green opacity-40"></div>
                    <div class="w-4 h-4 bg-brand-green-light rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                    <div class="w-8 h-0.5 bg-brand-green-dark opacity-30"></div>
                    <div class="w-2 h-2 bg-brand-green rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
                </div>
            </div>

            <!-- Mensaje motivacional -->
            <p class="text-sm text-gray-400 italic animate-pulse-slow">
                "Incluso los mejores exploradores a veces toman caminos inesperados..."
            </p>
        </div>
    </div>

    <!-- Elementos flotantes adicionales -->
    <div class="absolute top-0 left-0 w-6 h-6 border-2 border-brand-green-light rounded-full animate-spin-slow opacity-20"></div>
    <div class="absolute bottom-0 right-0 w-8 h-8 border-2 border-brand-green rounded-full animate-bounce-slow opacity-15"></div>
    <div class="absolute top-1/3 left-4 w-4 h-4 border border-brand-green-dark rounded-full animate-float opacity-25"></div>
</div>

<script>
// Efecto de mouse trail con partículas
document.addEventListener('mousemove', function(e) {
    if (Math.random() > 0.97) { // Solo crear partículas ocasionalmente
        const particle = document.createElement('div');
        particle.className = 'fixed pointer-events-none w-1 h-1 bg-brand-green rounded-full opacity-30 animate-ping';
        particle.style.left = e.clientX + 'px';
        particle.style.top = e.clientY + 'px';
        particle.style.zIndex = '9999';
        document.body.appendChild(particle);
        
        setTimeout(() => {
            if (document.body.contains(particle)) {
                document.body.removeChild(particle);
            }
        }, 1000);
    }
});

// Efecto de hover en el robot para hacerlo más interactivo
const robotSvg = document.querySelector('svg');
if (robotSvg) {
    robotSvg.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1) rotate(5deg)';
        this.style.transition = 'all 0.3s ease';
    });
    
    robotSvg.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1) rotate(0deg)';
    });
}
</script>