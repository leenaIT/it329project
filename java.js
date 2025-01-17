function showForm(role) {
  const patientForm = document.getElementById('patient-form');
  const doctorForm = document.getElementById('doctor-form');

  // إخفاء كل الفورم
  patientForm.classList.add('hidden');
  doctorForm.classList.add('hidden');

  // إظهار الفورم المناسب بناءً على الدور المحدد
  if (role === 'patient') {
      patientForm.classList.remove('hidden');
  } else if (role === 'doctor') {
      doctorForm.classList.remove('hidden');
  }

}

// عند تحميل الصفحة، إظهار الفورم الخاص بالمريض بشكل افتراضي
document.addEventListener("DOMContentLoaded", function() {
  const defaultRole = document.querySelector('input[name="role"]:checked');
  if (defaultRole) {
    showForm(defaultRole.value);
  } else {
    // افتراضي إظهار نموذج المريض
    showForm('patient');
  }

});

