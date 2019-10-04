if (document.querySelector('.drop-container')) {
    const dropdownButton = document.querySelector('.drop-container');
    const dropdownList = document.querySelector('.dropdown');

    function toggleDropdown() {
        let style = dropdownList.style;
        if (style.visibility === 'visible') {
            style.setProperty('visibility', 'hidden');
            style.setProperty('opacity', '0');
            return;
        }
        style.setProperty('visibility', 'visible');
        style.setProperty('opacity', '1');
    }

    dropdownButton.addEventListener('click', toggleDropdown);
}
