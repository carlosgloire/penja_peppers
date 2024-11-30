/*-----------------------------------/
#Css for handling like bouton
/-----------------------------------*/
    
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-button');

        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.closest('.blog-post').dataset.postId;
                const likeIcon = this.querySelector('i');
                const likeCountElement = this.nextElementSibling; // Assuming the like count is the next element after the button

                // Toggle the icon and like count directly
                if (likeIcon.classList.contains('bi-hand-thumbs-up')) {
                    // Simulate "like"
                    likeIcon.classList.remove('bi-hand-thumbs-up');
                    likeIcon.classList.add('bi-hand-thumbs-up-fill');
                    likeCountElement.textContent = parseInt(likeCountElement.textContent) + 1; // Increase like count
                } else {
                    // Simulate "unlike"
                    likeIcon.classList.remove('bi-hand-thumbs-up-fill');
                    likeIcon.classList.add('bi-hand-thumbs-up');
                    likeCountElement.textContent = parseInt(likeCountElement.textContent) - 1; // Decrease like count
                }
            });
        });
    });

/*-----------------------------------/
#Function to handle view more comments
/-----------------------------------*/
    document.addEventListener("DOMContentLoaded", () => {
        // Get all "View more comments" buttons
        const toggleButtons = document.querySelectorAll(".toggle-comments");

        toggleButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Find the comments container within the same post
                const commentSection = this.closest(".comment-section");
                const comments = commentSection.querySelectorAll(".comment");

                // Check if currently viewing more or less
                const isExpanded = this.textContent === "View less comments";

                if (isExpanded) {
                    // Hide all but the first two comments
                    comments.forEach((comment, index) => {
                        if (index > 1) comment.classList.add("hidden");
                    });
                    this.textContent = "View more comments";
                } else {
                    // Show all comments
                    comments.forEach(comment => comment.classList.remove("hidden"));
                    this.textContent = "View less comments";
                }
            });
        });
    });

/*-----------------------------------/
#Function to handle edit comment
/-----------------------------------*/
    document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-comment');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const commentDiv = this.closest('.comment');
            const commentId = commentDiv.dataset.commentId;
            const commentText = commentDiv.querySelector('.comment-text');

            // Convert text to an editable input
            const input = document.createElement('textarea');
            input.value = commentText.textContent;
            input.classList.add('edit-input');
            commentDiv.replaceChild(input, commentText);

            // Replace Edit button with Save
            const saveButton = document.createElement('button');
            saveButton.textContent = 'Save';
            saveButton.classList.add('save-comment');
            this.replaceWith(saveButton);

            saveButton.addEventListener('click', function () {
                const updatedComment = input.value;

                // Send update to server
                fetch('edit_comment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ comment_id: commentId, comment: updatedComment })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI with new comment
                            commentText.textContent = updatedComment;
                            commentDiv.replaceChild(commentText, input);
                            saveButton.replaceWith(button); // Replace Save with Edit
                        } else {
                            alert(data.message || 'Failed to update comment.');
                        }
                    })
                    .catch(() => alert('An error occurred while updating the comment.'));
            });
        });
    });
});
/*-----------------------------------/
#Function to handle delete comment
/-----------------------------------*/
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-comment');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete this comment?')) {
                const commentDiv = this.closest('.comment');
                const commentId = commentDiv.dataset.commentId;

                // Send delete request to server
                fetch('delete_comment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ comment_id: commentId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove comment from UI
                            commentDiv.remove();
                        } else {
                            alert(data.message || 'Failed to delete comment.');
                        }
                    })
                    .catch(() => alert('An error occurred while deleting the comment.'));
            }
        });
    });
});

/*-----------------------------------/
#Function to handle share posr
/-----------------------------------*/
document.addEventListener('DOMContentLoaded', function () {
    const shareButtons = document.querySelectorAll('.share-button');
    const popup = document.getElementById('share-popup');
    const closePopupButton = document.getElementById('close-popup');

    // Handle Share Button Click
    shareButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postLink = this.getAttribute('data-link');
            const shareText = encodeURIComponent('Check out this amazing blog post!');

            // Update sharing links dynamically
            document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postLink)}`;
            document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(postLink)}&text=${shareText}`;
            document.getElementById('share-whatsapp').href = `https://api.whatsapp.com/send?text=${shareText} ${encodeURIComponent(postLink)}`;
            document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(postLink)}`;

            // Show the popup with animation
            popup.style.display = 'block'; // Make sure it's visible
            setTimeout(() => {
                popup.classList.add('active'); // Add the active class to trigger animation
            }, 10); // Slight delay to allow `display: block` to take effect
        });
    });

    // Handle Close Button Click
    closePopupButton.addEventListener('click', function () {
        popup.classList.remove('active'); // Remove the animation class
        setTimeout(() => {
            popup.style.display = 'none'; // Hide after animation ends
        }, 300); // Match the duration of the CSS transition
    });
});
