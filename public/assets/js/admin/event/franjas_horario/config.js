// franjas_horario config.js
export const HORARIO_INICIO = 6;
export const HORARIO_FIN = 22;
export const INTERVALO_MINUTOS = 30;

export const SELECTORS = {
  timeline: 'timeline-container',
  horaInicio: 'hora_inicio',
  horaFin: 'hora_fin',
  selectedDisplay: 'selected-time-display',
  duracionDisplay: 'duracion-display',
  fecha: 'fecha_evento',
  lugar: 'lugar_evento',
  occupiedInfo: 'occupied-events-info',
  form: 'form'
};

let _baseUrl = '';

export function setBaseUrl(url) {
  if (typeof url === 'string') {
    _baseUrl = url.replace(/\/+$/, '');
  }
}

export function getBaseUrl() {
  if (_baseUrl) return _baseUrl;
  if (typeof globalThis !== 'undefined' && typeof globalThis.URL_PATH === 'string') {
    return globalThis.URL_PATH.replace(/\/+$/, '');
  }
  return '';
}

export function endpoint(path) {
  const base = getBaseUrl();
  return new URL(path.replace(/^\/+/, ''), base + '/').toString();
}
