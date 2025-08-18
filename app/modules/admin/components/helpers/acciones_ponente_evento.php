<?php
// app/modules/admin/helpers/acciones_ponente_evento.php
?>

<div class="flex justify-end space-x-2">
  <a
    href="<?= URL_PATH ?>/admin/detallePonente/<?= $ponente['id_ponente'] ?>"
    class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-150"
    title="Ver detalles del ponente"
  >
    <svg
      class="w-5 h-5"
      viewBox="0 0 640 640"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
    >
      <path
        d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"
      />
    </svg>
  </a>
  
  <a
    href="<?= URL_PATH ?>/admin/editarPonentevento/<?= $ponente['id_ponente_evento'] ?>"
    class="text-indigo-600 hover:text-indigo-800 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-150"
    title="Editar asignación"
  >
    <svg
      class="w-5 h-5"
      viewBox="0 0 640 640"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
    >
      <path
        d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z"
      />
    </svg>
  </a>

  <?php if ($ponente['certificado_generado'] == 0): ?>
  <button
    onclick="generarCertificado(<?= $ponente['id_ponente_evento'] ?>, '<?= htmlspecialchars($ponente['tema']) ?>')"
    class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-150"
    title="Generar certificado"
  >
    <svg
      class="w-5 h-5"
      viewBox="0 0 640 640"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
    >
      <path
        d="M211 7.3C205 1 196-1.4 187.6 .8L32.1 52.1C14.5 58.9 0 76.5 0 96.5V560C0 578.2 11.2 594.6 28.1 603.9C45 613.2 66.6 610.4 80.4 596.4L127.8 548.1L140.9 558.9C154.3 570.2 173.4 570.2 186.8 558.9L200.4 547.8L213.6 558.9C227 570.2 246.1 570.2 259.5 558.9L272.6 547.8L285.8 558.9C299.2 570.2 318.3 570.2 331.7 558.9L345.3 547.8L358.4 558.9C371.8 570.2 390.9 570.2 404.3 558.9L418.4 547.8L431.5 558.9C444.9 570.2 464 570.2 477.4 558.9L490.5 547.8L503.7 558.9C517.1 570.2 536.2 570.2 549.6 558.9L562.2 548.1L609.6 596.4C623.4 610.4 645 613.2 661.9 603.9C678.8 594.6 690 578.2 690 560V96.5C690 76.5 675.5 58.9 657.9 52.1L502.4 .8C494-1.4 485 1 479 7.3L345 141.4L211 7.3zM64 141.1L175.4 60.9L272.9 158.4L193.7 237.6L64 141.1zM64 218.3L139.5 267.1L227.3 354.9L139.5 442.7L64 491.5V218.3zM208 295.8L295.8 383.6L208 471.4L120.2 383.6L208 295.8zM276.2 354.9L364 267.1L438.5 218.3V491.5L364 442.7L276.2 354.9zM193.7 237.6L272.9 158.4L370.4 60.9L481.8 141.1L364 268.9L193.7 237.6z"
      />
    </svg>
  </button>
  <?php endif; ?>

  <button
    onclick="eliminarPonenteEvento(<?= $ponente['id_ponente_evento'] ?>, '<?= htmlspecialchars($ponente['tema']) ?>', '<?= htmlspecialchars($ponente['titulo_evento']) ?>')"
    class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-150"
    title="Remover ponente del evento"
  >
    <svg
      class="w-5 h-5"
      viewBox="0 0 640 640"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
    >
      <path
        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64C0 81.7 14.3 96 32 96H96V480C96 530 138 572 192 572H448C502 572 544 530 544 480V96H608C625.7 96 640 81.7 640 64C640 46.3 625.7 32 608 32H512L504.8 17.7C497.1 5.2 483.8 0 469.6 0H170.4C156.2 0 142.9 5.2 135.2 17.7zM480 96V480C480 496.6 466.6 512 448 512H192C175.4 512 160 496.6 160 480V96H480zM240 176C240 158.3 254.3 144 272 144C289.7 144 304 158.3 304 176V400C304 417.7 289.7 432 272 432C254.3 432 240 417.7 240 400V176zM336 176C336 158.3 350.3 144 368 144C385.7 144 400 158.3 400 176V400C400 417.7 385.7 432 368 432C350.3 432 336 417.7 336 400V176z"
      />
    </svg>
  </button>
</div>

<script>
// Función para generar certificado
function generarCertificado(idPonenteEvento, tema) {
  Swal.fire({
    title: '¿Generar certificado?',
    text: `Se generará el certificado para el tema: ${tema}`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#059669',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Sí, generar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`<?= URL_PATH ?>/admin/generarCertificado`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id_ponente_evento: idPonenteEvento
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            title: 'Certificado generado',
            text: data.message,
            icon: 'success',
            confirmButtonColor: '#059669'
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: 'Error',
            text: data.message,
            icon: 'error',
            confirmButtonColor: '#dc2626'
          });
        }
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al generar el certificado',
          icon: 'error',
          confirmButtonColor: '#dc2626'
        });
      });
    }
  });
}

// Función para eliminar ponente del evento
function eliminarPonenteEvento(idPonenteEvento, tema, evento) {
  Swal.fire({
    title: '¿Estás seguro?',
    html: `Se eliminará la asignación:<br><strong>Tema:</strong> ${tema}<br><strong>Evento:</strong> ${evento}`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`<?= URL_PATH ?>/admin/eliminarPonenteEvento`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id_ponente_evento: idPonenteEvento
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            title: 'Eliminado',
            text: data.message,
            icon: 'success',
            confirmButtonColor: '#059669'
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            title: 'Error',
            text: data.message,
            icon: 'error',
            confirmButtonColor: '#dc2626'
          });
        }
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al eliminar la asignación',
          icon: 'error',
          confirmButtonColor: '#dc2626'
        });
      });
    }
  });
}
</script>