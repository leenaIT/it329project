function showForm() {
  // الحصول على قيمة الزر المحدد
  const selectedRole = document.querySelector('input[name="role"]:checked').value;

  // إخفاء كل الفورمات
  document.getElementById('patientForm').classList.add('hidden');
  document.getElementById('doctorForm').classList.add('hidden');

  // إظهار الفورم المناسب بناءً على الدور
  if (selectedRole === 'patient') {
      document.getElementById('patientForm').classList.remove('hidden');
  } else if (selectedRole === 'doctor') {
      document.getElementById('doctorForm').classList.remove('hidden');
  }
}