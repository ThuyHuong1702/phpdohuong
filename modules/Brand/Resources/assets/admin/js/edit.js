document.querySelectorAll('.name').forEach(row => {
    row.addEventListener('click', () => {
        const id = row.querySelector('.select-row').value;
        window.location.href = `/admin/brands/edit`;
    });
});
