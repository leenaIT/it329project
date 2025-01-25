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
function handleSubmit(event) {
  event.preventDefault(); // منع إعادة تحميل الصفحة
  const selectedRole = document.querySelector('input[name="role"]:checked');
  
  if (!selectedRole) {
    alert("Please select a role before submitting!"); // تنبيه إذا لم يتم اختيار أي خيار
    return;
  }
  
  if (selectedRole.value === "doctor") {
    window.location.href = "DoctorPage.html"; // توجيه إلى صفحة الدكتور
  } else if (selectedRole.value === "patient") {
    window.location.href = "Patient.html"; // توجيه إلى صفحة المريض
  }
}