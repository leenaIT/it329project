(function servicesCarousel() {
  const carousel = document.querySelector(".services-carousel");
  const leftArrow = document.getElementById("leftArrow");
  const rightArrow = document.getElementById("rightArrow");
  const services = document.querySelectorAll(".service");
  const totalServices = services.length;
  const visibleServices = 3; 
  const serviceWidth = 100 / visibleServices; 

  let currentIndex = 0;

  function updateServicesCarousel() {
    const offset = -(currentIndex * serviceWidth); 
    carousel.style.transform = `translateX(${offset}%)`;  

    leftArrow.disabled = currentIndex === 0;
    rightArrow.disabled = currentIndex >= totalServices - visibleServices;

    leftArrow.style.display = currentIndex === 0 ? "none" : "block";
    rightArrow.style.display =
      currentIndex + visibleServices >= totalServices ? "none" : "block";
  }

  rightArrow.addEventListener("click", () => {
    if (currentIndex < totalServices - visibleServices) {
      currentIndex++;
      updateServicesCarousel();
    }
  });

  leftArrow.addEventListener("click", () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateServicesCarousel();
    }
  });

  updateServicesCarousel();
})();

(function reviewsCarousel() {
  const carouselItems = document.querySelectorAll(".carousel-item");
  let activeIndex = 1; 

  function updateReviewsCarousel() {
    carouselItems.forEach((item, index) => {
      item.classList.remove("active", "left", "right", "hidden");

      if (index === activeIndex) {
        item.classList.add("active");
      } else if (index === (activeIndex - 1 + carouselItems.length) % carouselItems.length) {
        item.classList.add("left");
      } else if (index === (activeIndex + 1) % carouselItems.length) {
        item.classList.add("right");
      } else {
        item.classList.add("hidden");
      }
    });
  }

  function nextReview() {
    activeIndex = (activeIndex + 1) % carouselItems.length;
    updateReviewsCarousel();
  }

  function prevReview() {
    activeIndex = (activeIndex - 1 + carouselItems.length) % carouselItems.length;
    updateReviewsCarousel();
  }

  function handleClick(event) {
    const clickedIndex = [...carouselItems].indexOf(event.currentTarget);
    if (clickedIndex !== activeIndex) {
      activeIndex = clickedIndex;
      updateReviewsCarousel();
    }
  }

  let autoScroll = setInterval(nextReview, 2000);

  carouselItems.forEach((item) => {
    item.addEventListener("click", handleClick);
    item.addEventListener("mouseover", () => clearInterval(autoScroll));
    item.addEventListener("mouseleave", () => autoScroll = setInterval(nextReview, 5000));
  });

  updateReviewsCarousel();
})();

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
