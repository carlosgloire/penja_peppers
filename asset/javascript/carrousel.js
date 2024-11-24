document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".product-container-similar");
    const products = document.querySelectorAll(".product");
    const prevButton = document.querySelector(".carousel-nav.prev");
    const nextButton = document.querySelector(".carousel-nav.next");
    let currentIndex = 0;
  
    const updateCarousel = () => {
      const productWidth = products[0].offsetWidth + 20; // Includes margin
      container.style.transform = `translateX(-${currentIndex * productWidth}px)`;
    };
  
    prevButton.addEventListener("click", () => {
      currentIndex = Math.max(currentIndex - 1, 0);
      updateCarousel();
    });
  
    nextButton.addEventListener("click", () => {
      currentIndex = Math.min(
        currentIndex + 1,
        products.length - 6 // Adjust based on the number of visible items
      );
      updateCarousel();
    });
  
    // Adjust carousel position on window resize
    window.addEventListener("resize", updateCarousel);
  });
  