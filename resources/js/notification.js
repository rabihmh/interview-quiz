function updateNotificationDropdown(data) {
    let notification_count = parseInt(document.querySelector('#notification-count').textContent);
    notification_count++;
    document.querySelector('#notification-count').textContent = notification_count;
    const dropdown = document.querySelector('.main-notification-list');

    const notificationHTML = `
        <a class="dropdown-item d-flex align-items-center" href="${data.url}">
            <div class="mr-3">
                <div class="icon-circle bg-success">
                    <i class="fas fa-info text-white"></i>
                </div>
            </div>
            <div>
                <span class="font-weight-bold">${data.body}</span>
            </div>
        </a>
    `;
    dropdown.insertAdjacentHTML('afterbegin', notificationHTML);
}
let channel = Echo.private(`App.Models.Admin.${authID}`);
channel.listen('.order-create', function (data) {
    updateNotificationDropdown(data);
});

