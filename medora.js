const carousel = document.querySelector(".services-carousel");
const leftArrow = document.getElementById("leftArrow");
const rightArrow = document.getElementById("rightArrow");
const services = document.querySelectorAll(".service");
const totalServices = services.length;
const visibleServices = 3; // عدد الخدمات الظاهرة
const serviceWidth = 100 / visibleServices; // عرض كل خدمة كنسبة مئوية

let currentIndex = 0;

// تحديث الكاروسيل
function updateCarousel() {
  const offset = -(currentIndex * serviceWidth); // احسب الترجمة
  carousel.style.transform = `translateX(${offset}%)`; // طبق الترجمة

  // تفعيل/تعطيل الأسهم بناءً على الموضع الحالي
  leftArrow.disabled = currentIndex === 0;
  rightArrow.disabled = currentIndex >= totalServices - visibleServices;
  if (currentIndex + visibleServices >= totalServices) {
    rightArrow.style.display = "none";
  } else {
    rightArrow.style.display = "block";
  }

  // إظهار أو إخفاء السهم الأيسر
  if (currentIndex === 0) {
    leftArrow.style.display = "none";
  } else {
    leftArrow.style.display = "block";
  }
}

// عند الضغط على السهم الأيمن
rightArrow.addEventListener("click", () => {
  if (currentIndex < totalServices - visibleServices) {
    currentIndex++;
    updateCarousel();
  }
});

// عند الضغط على السهم الأيسر
leftArrow.addEventListener("click", () => {
  if (currentIndex > 0) {
    currentIndex--;
    updateCarousel();
  }
});

// تهيئة الكاروسيل
updateCarousel();

