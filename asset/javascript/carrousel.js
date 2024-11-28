document.addEventListener('DOMContentLoaded', function () {
  // Get the carousel navigation arrows
  const leftArrow = document.querySelector('.bi-chevron-left');
  const rightArrow = document.querySelector('.bi-chevron-right');
  
  // Get the product container
  const productContainer = document.getElementById('product-container-similar');
  
  // If the container exists, enable the scrolling
  if (productContainer) {
      leftArrow.addEventListener('click', function () {
          // Scroll the container to the left by 300px smoothly
          productContainer.scrollBy({
              left: -300,
              behavior: 'smooth'
          });
      });

      rightArrow.addEventListener('click', function () {
          // Scroll the container to the right by 300px smoothly
          productContainer.scrollBy({
              left: 300,
              behavior: 'smooth'
          });
      });
  }
});
