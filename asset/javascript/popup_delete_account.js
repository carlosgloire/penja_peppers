document.addEventListener('DOMContentLoaded', () => {
    const deleteButton = document.getElementById('open');
    const popup = document.querySelector('.popup');
    const cancelButton = document.querySelector('.cancel-popup');

    deleteButton.addEventListener('click', () => {
        popup.classList.remove('hidden-popup-delete');
    });

    cancelButton.addEventListener('click', () => {
        popup.classList.add('hidden-popup-delete');
    });
});
