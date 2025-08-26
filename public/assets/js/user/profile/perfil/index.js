// index.js
import { setupProfileForm } from "./profile_form.js";
import { setupPasswordForm } from "./password_form.js";

window.addEventListener("DOMContentLoaded", () => {
  setupProfileForm(URL_PATH, document);
  setupPasswordForm(URL_PATH, document);
});
