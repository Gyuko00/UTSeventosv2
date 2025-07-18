export const validations = [
  {
    field: "tipo_documento",
    validation: (value) => !value,
    error: "Debe seleccionar un tipo de documento.",
  },
  {
    field: "numero_documento",
    validation: (value) => !/^\d{5,10}$/.test(value),
    error:
      "El número de documento debe contener solo números, entre 5 y 10 dígitos. No se permiten letras, espacios ni emojis.",
  },
  {
    field: "nombres",
    validation: (value) => !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(value),
    error:
      "Los nombres deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
  },
  {
    field: "apellidos",
    validation: (value) => !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(value),
    error:
      "Los apellidos deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
  },
  {
    field: "telefono",
    validation: (value) => !/^\d{7,13}$/.test(value.replace(/\D/g, "")),
    error: "El teléfono debe contener solo números (entre 7 y 13 dígitos).",
  },
  {
    field: "correo_personal",
    validation: (value) => !/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i.test(value),
    error: "Ingrese un correo electrónico válido.",
  },
  {
    field: "departamento",
    validation: (value) => !value,
    error: "Debe seleccionar un departamento.",
  },
  {
    field: "municipio",
    validation: (value) => !value,
    error: "Debe seleccionar un municipio.",
  },
  {
    field: "direccion",
    validation: (value) => value.length < 5 || value.length > 100,
    error: "La dirección debe tener entre 5 y 100 caracteres, sin emojis.",
  },
  {
    field: "usuario",
    validation: (value) => !/^[a-zA-Z0-9_.-]{4,20}$/.test(value),
    error:
      "El nombre de usuario debe tener entre 4 y 20 caracteres. Solo se permiten letras, números, guiones, puntos y guiones bajos.",
  },
  {
    field: "contrasenia",
    validation: (value) =>
      !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/.test(value),
    error:
      "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos una letra mayúscula, una minúscula y un número. No se permiten emojis.",
  },
];
