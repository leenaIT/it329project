// كاروسيل الخدمات
(function servicesCarousel() {
  const carousel = document.querySelector(".services-carousel");
  const leftArrow = document.getElementById("leftArrow");
  const rightArrow = document.getElementById("rightArrow");
  const services = document.querySelectorAll(".service");
  const totalServices = services.length;
  const visibleServices = 3; // عدد الخدمات الظاهرة
  const serviceWidth = 100 / visibleServices; // عرض كل خدمة كنسبة مئوية

  let currentIndex = 0;

  // تحديث الكاروسيل
  function updateServicesCarousel() {
    const offset = -(currentIndex * serviceWidth); // احسب الترجمة
    carousel.style.transform = `translateX(${offset}%)`; // طبق الترجمة

    // تفعيل/تعطيل الأسهم بناءً على الموضع الحالي
    leftArrow.disabled = currentIndex === 0;
    rightArrow.disabled = currentIndex >= totalServices - visibleServices;

    // إظهار أو إخفاء الأسهم
    leftArrow.style.display = currentIndex === 0 ? "none" : "block";
    rightArrow.style.display =
      currentIndex + visibleServices >= totalServices ? "none" : "block";
  }

  // عند الضغط على السهم الأيمن
  rightArrow.addEventListener("click", () => {
    if (currentIndex < totalServices - visibleServices) {
      currentIndex++;
      updateServicesCarousel();
    }
  });

  // عند الضغط على السهم الأيسر
  leftArrow.addEventListener("click", () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateServicesCarousel();
    }
  });

  // تهيئة الكاروسيل
  updateServicesCarousel();
})();

// كاروسيل المراجعات المحدث
(function reviewsCarousel() {
  const carouselItems = document.querySelectorAll(".carousel-item");
  let activeIndex = 1; // Start with the second item as active

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

  // Auto-scroll every 5 seconds
  let autoScroll = setInterval(nextReview, 2000);

  // Pause auto-scroll on hover
  carouselItems.forEach((item) => {
    item.addEventListener("click", handleClick);
    item.addEventListener("mouseover", () => clearInterval(autoScroll));
    item.addEventListener("mouseleave", () => autoScroll = setInterval(nextReview, 5000));
  });

  updateReviewsCarousel();
})();
