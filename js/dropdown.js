document.addEventListener('DOMContentLoaded', function () {
    // Находим элементы для ссылки и выпадающего меню
    const profileLink = document.querySelector('.profile-link');
    const profileDropdown = document.querySelector('.profile-dropdown');

    // Показываем выпадающее меню при наведении на ссылку "Профиль"
    profileLink.addEventListener('mouseover', function() {
        profileDropdown.style.display = 'block';
    });

    // Скрываем выпадающее меню, когда уходим с блока
    profileLink.addEventListener('mouseleave', function() {
        profileDropdown.style.display = 'none';
    });

    // Скрытие выпадающего меню, если кликнули вне него
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.profile-link-wrapper')) {
            profileDropdown.style.display = 'none';
        }
    });
});
