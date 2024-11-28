// JavaScript to toggle the hamburger menu
document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.menu-icon');
    const exitIcon = document.querySelector('.exit-icon');
    const listDetails = document.querySelector('.nav-links');
    const ourMenu = document.querySelector('.our-menu');

    // Show the menu when the hamburger icon is clicked
    menuIcon.addEventListener('click', function () {
        listDetails.classList.add('active');  // Show the menu
        ourMenu.classList.add('active');      // Hide the menu icon and show the exit icon
    });

    // Hide the menu when the exit icon is clicked
    exitIcon.addEventListener('click', function () {
        listDetails.classList.remove('active');  // Hide the menu
        ourMenu.classList.remove('active');      // Show the menu icon and hide the exit icon
    });
});

/* Codes to handle the slides  */
document.addEventListener('DOMContentLoaded', () => {
const homeImage = document.querySelectorAll('.home-bg');
const circles = document.querySelectorAll('.circle');
let currentIndex = 0;

function showItem(index) {
    homeImage[currentIndex].style.display = 'none';
    circles[currentIndex].classList.remove('active');
    homeImage[index].style.display = 'block';
    circles[index].classList.add('active');
    currentIndex = index;
}

function showNextItem() {
    const nextIndex = (currentIndex + 1) % homeImage.length;
    showItem(nextIndex);
}

function showPreviousItem() {
    const prevIndex = (currentIndex - 1 + homeImage.length) % homeImage.length;
    showItem(prevIndex);
}

function goToItem(index) {
    showItem(index);
}

// Initial display setup
homeImage.forEach((item, index) => {
    if (index !== currentIndex) {
        item.style.display = 'none';
    }
});

circles.forEach((circle, index) => {
    circle.addEventListener('click', () => {
        goToItem(index);
    });
});

// Auto-scroll functionality
setInterval(showNextItem, 5000);
});

document.addEventListener("DOMContentLoaded", () => {
    const searchIcon = document.querySelector(".search-icon");
    const searchContainer = document.querySelector(".search-container");

    searchIcon.addEventListener("click", () => {
        searchContainer.classList.toggle("active");
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const searchIcon = document.querySelector(".search-icon2");
    const searchContainer = document.querySelector(".search-container2");

    searchIcon.addEventListener("click", () => {
        searchContainer.classList.toggle("active");
    });
});



// Toggle the reviews visibility
function toggleReviews() {
    const moreReviews = document.getElementById('more-reviews');
    const button = document.getElementById('toggle-reviews');

    if (moreReviews.style.display === 'none') {
        moreReviews.style.display = 'block';
        button.textContent = 'Show Less Reviews'; // Change button text to "Show Less Reviews"
    } else {
        moreReviews.style.display = 'none';
        button.textContent = 'Show More Reviews'; // Change button text back to "Show More Reviews"
    }
}
