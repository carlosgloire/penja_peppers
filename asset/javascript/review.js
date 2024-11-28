document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const product = urlParams.get('product');  // Get the 'product' parameter from the URL
    let selectedRating = 0;

    const starRows = document.querySelectorAll('.star-row');
    const submitBtn = document.getElementById('submit-btn');
    const reviewForm = document.getElementById('reviewForm');
    const ratingInput = document.getElementById('rating');
    const productInput = document.getElementById('product');  // This will hold the 'product' value

    productInput.value = product;  // Set the value of the product input field

    starRows.forEach(row => {
        row.addEventListener('click', () => {
            selectedRating = row.getAttribute('data-value');
            ratingInput.value = selectedRating;
            starRows.forEach(r => r.classList.remove('selected'));
            row.classList.add('selected');
        });

        row.addEventListener('mouseenter', () => {
            row.classList.add('hovered');
        });

        row.addEventListener('mouseleave', () => {
            row.classList.remove('hovered');
        });
    });

    submitBtn.addEventListener('click', () => {
        console.log('Selected Rating:', selectedRating);  // Log the rating value
        console.log('Rating Input Value:', ratingInput.value);  // Log the value sent in the form

        if (selectedRating > 0 && product) {
            reviewForm.submit();  // Submit the form if rating and product are selected
        } else {
            alert("Please select a rating before submitting your review.");
        }
    });
});
