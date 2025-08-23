// Config y selectores centralizados

export const SLOT_MINUTES = 30;

export const IDS = {
  container: 'ponente-timeline-container',
  slots: 'ponente-timeline-slots',
  display: 'ponente-selected-display',
  horaInput: 'hora_participacion',
};

export function getEventoSelect() {
  return (
    document.querySelector('select[name="speaker_event[id_evento]"]') ||
    document.querySelector('select[name="id_evento"]') ||
    document.getElementById('id_evento')
  );
}

export function getHoraInput() {
  return (
    document.getElementById(IDS.horaInput) ||
    document.querySelector('input[name="speaker_event[hora_participacion]"]')
  );
}
