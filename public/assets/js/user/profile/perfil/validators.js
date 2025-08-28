// validators.js
export function validatePasswordFields(actual, nueva, confirmar) {
  const a = actual?.trim() || "",
    n = nueva?.trim() || "",
    c = confirmar?.trim() || "";

  if (!a && !n && !c) {
    return {
      ok: false,
      type: "info",
      msg: "No has ingresado ninguna contraseña para cambiar",
    };
  }
  if (!a || !n || !c) {
    return {
      ok: false,
      type: "warning",
      msg: "Para cambiar la contraseña, debes llenar todos los campos",
    };
  }
  if (n !== c) {
    return {
      ok: false,
      type: "error",
      msg: "Las contraseñas no coinciden",
      focus: "confirmar_contrasena",
    };
  }
  if (n.length < 6) {
    return {
      ok: false,
      type: "error",
      msg: "La contraseña debe tener al menos 6 caracteres",
      focus: "nueva_contrasena",
    };
  }
  if (a === n) {
    return {
      ok: false,
      type: "warning",
      msg: "La nueva contraseña debe ser diferente a la actual",
      focus: "nueva_contrasena",
    };
  }
  return { ok: true };
}

export function attachLivePasswordValidation(doc = document) {
  const $nueva = doc.getElementById("nueva_contrasena");
  const $confirmar = doc.getElementById("confirmar_contrasena");

  const paint = (el, ok, warn = false) => {
    if (!el) return;
    if (ok) {
      el.style.borderColor = "#d1d5db";
      el.style.backgroundColor = "#ffffff";
      el.classList.remove("border-red-500");
      el.classList.add("border-gray-300");
      el.setCustomValidity("");
    } else {
      el.setCustomValidity(warn ? "" : "Las contraseñas no coinciden");
      if (warn) {
        el.style.borderColor = "#f59e0b";
        el.style.backgroundColor = "#fffbeb";
      } else {
        el.style.borderColor = "#ef4444";
        el.style.backgroundColor = "#fef2f2";
        el.classList.add("border-red-500");
        el.classList.remove("border-gray-300");
      }
    }
  };

  $confirmar?.addEventListener("input", function () {
    const n = $nueva?.value || "",
      c = this.value || "";
    paint(this, !c || n === c);
  });

  $nueva?.addEventListener("input", function () {
    const len = this.value.length;
    paint(this, !(len > 0 && len < 6), true);
    const c = $confirmar?.value || "";
    if ($confirmar && c) paint($confirmar, this.value === c);
  });
}
