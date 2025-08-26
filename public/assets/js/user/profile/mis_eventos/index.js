// index.js (entrypoint)
import { fetchMisEventos } from "./api.js";
import { renderEventos, renderError } from "./ui.js";
import { attachCertificateHandler } from "./certificates.js";

class MisEventos {
  constructor() {
    this.container = document.getElementById("mis-eventos-container");
    this.loadingElement = document.getElementById("eventos-loading");
    this.contentElement = document.getElementById("eventos-content");
    this.detachCertificates = attachCertificateHandler(document, URL_PATH);
    this.cargarEventos();
  }

  async cargarEventos() {
    if (!this.contentElement || !this.loadingElement) return;

    this.loadingElement.classList.remove("hidden");
    try {
      const data = await fetchMisEventos(URL_PATH);
      renderEventos(this.contentElement, data);
    } catch (err) {
      renderError(this.contentElement, err.message || "Error al cargar los eventos");
    } finally {
      this.loadingElement.classList.add("hidden");
      this.contentElement.classList.remove("hidden");
    }
  }
}

window.addEventListener("DOMContentLoaded", () => {
  new MisEventos();
});
