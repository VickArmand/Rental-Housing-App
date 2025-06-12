export const emailRule = (email) =>
  /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) || "Invalid Email";
export const minLengthLimit = (length) => (val) =>
  (val && val.length >= length) ||
  `Value must be at least ${length} characters long`;
export const pwdHasUppercase = (val) =>
  /[A-Z]/.test(val) || "Password must contain at least one uppercase letter";
export const pwdHasNumber = (val) =>
  /\d/.test(val) || "Password must contain at least one number";
export const pwdHasSpecial = (val) =>
  /[!@#$%^&*(),.?":{}|<>]/.test(val) ||
  "Password must contain at least one special character";
export const pwdMatch = (pwd) => (val) =>
  pwd === val || "Passwords do not match";
export const requiredRule = (v) => !!v || "This Field is required";
export const numbersOnly = (val) =>
  /^\d+$/.test(val) || "Only digits are allowed on this field";
export const lettersOnly = (val) =>
  /^[A-Za-z]+$/.test(val) || "Only letters are allowed on this field";
