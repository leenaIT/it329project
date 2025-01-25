document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.querySelector('input[name="role"]:checked')?.value;

    // تحقق من اختيار الدور
    if (!role) {
        alert('Please select your role (Patient or Doctor).');
        return;
    }

    // توجيه المستخدم إلى الصفحة المناسبة بناءً على الدور
    if (role === 'patient') {
        window.location.href = 'patient-homepage.html';  // توجه إلى صفحة المريض
    } else if (role === 'doctor') {
        window.location.href = 'doctor-homepage.html';  // توجه إلى صفحة الطبيب
    }
});

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