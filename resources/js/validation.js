function validateTIP(tip) {
  var regex = /^[a-zA-Z][0-9]{5}[A-Za-z]$/;
  return regex.test(tip);
}

function validateEmail(email) {
  var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return regex.test(email);
}

function setupFormValidations() {
  var TIPInput = document.getElementById('TIPInput');
  var tipValidation = document.getElementById('tipValidation');
  var emailInput = document.getElementById('emailInput');
  var emailValidation = document.getElementById('emailValidation');

  TIPInput.addEventListener('blur', function() {
    var tip = TIPInput.value;
    if (!validateTIP(tip)) {
      TIPInput.classList.add('is-invalid');
      tipValidation.style.display = 'block';
    } else {
      TIPInput.classList.remove('is-invalid');
      tipValidation.style.display = 'none';
    }
  });

  emailInput.addEventListener('blur', function() {
    var email = emailInput.value;
    if (!validateEmail(email)) {
      emailInput.classList.add('is-invalid');
      emailValidation.style.display = 'block';
    } else {
      emailInput.classList.remove('is-invalid');
      emailValidation.style.display = 'none';
    }
  });
}