function setError(el, message) {
  const err = el.closest('div')?.querySelector('.form-error');
  if (err) err.textContent = message || '';
  el.setAttribute('aria-invalid', !!message);
}

function clearErrors(form) {
  form.querySelectorAll('.form-error').forEach(e => e.textContent = '');
  form.querySelectorAll('[aria-invalid]').forEach(i => i.removeAttribute('aria-invalid'));
}

function validateField(el) {
  if (!el) return true;
  const required = el.hasAttribute('required');
  const val = el.type === 'file' ? el.files[0] : el.value.trim();

  if (required && (!val || (el.type === 'file' && !el.files.length))) {
    setError(el, 'Field ini wajib diisi');
    return false;
  }

  if (el.type === 'email' && val) {
    const re = /^\S+@\S+\.\S+$/;
    if (!re.test(val)) { setError(el, 'Email tidak valid'); return false; }
  }

  // file validation (optional): limit to 5MB
  if (el.type === 'file' && el.files.length) {
    const f = el.files[0];
    if (f.size > 5 * 1024 * 1024) { setError(el, 'Ukuran file maksimal 5MB'); return false; }
  }

  setError(el, '');
  return true;
}

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form.needs-validation');
  if (!forms.length) return;

  forms.forEach(form => {
    form.addEventListener('submit', (e) => {
      clearErrors(form);
      const inputs = Array.from(form.querySelectorAll('input, textarea, select'));
      let valid = true;
      for (const input of inputs) {
        if (!validateField(input)) {
          if (valid) input.focus();
          valid = false;
        }
      }

      if (!valid) {
        e.preventDefault();
        e.stopPropagation();
      } else {
        // disable submit to prevent double submits
        const btn = form.querySelector('button[type=submit]');
        if (btn) btn.disabled = true;
      }
    });

    // live validation
    form.addEventListener('input', (e) => {
      validateField(e.target);
    });
  });
});

export {};
