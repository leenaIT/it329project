function showForm() {
  const selectedRole = document.querySelector('input[name="role"]:checked').value;

  document.getElementById('patientForm').classList.add('hidden');
  document.getElementById('doctorForm').classList.add('hidden');

  if (selectedRole === 'patient') {
      document.getElementById('patientForm').classList.remove('hidden');
  } else if (selectedRole === 'doctor') {
      document.getElementById('doctorForm').classList.remove('hidden');
  }
}
function handleSubmit(event) {
  event.preventDefault(); 
  const selectedRole = document.querySelector('input[name="role"]:checked');
  
  if (!selectedRole) {
    alert("Please select a role before submitting!"); 
    return;
  }
  
  if (selectedRole.value === "doctor") {
    window.location.href = "DoctorPage.html"; 
  } else if (selectedRole.value === "patient") {
    window.location.href = "Patient.html"; 
  }
}