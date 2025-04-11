// Clone and move the navbar for mobile sidebar
document.addEventListener("DOMContentLoaded", function () {
    const originalMenu = document.querySelector(".main-menu .navbar-collapse");
    const clonedMenu = originalMenu.cloneNode(true);
    clonedMenu.classList.add("mobile-offcanvas");
    clonedMenu.classList.remove("collapse");

    // Add close button
    const closeBtn = document.createElement("div");
    closeBtn.classList.add("offcanvas-close");
    closeBtn.innerHTML = "&times;";
    clonedMenu.prepend(closeBtn);

    // Append to body
    document.body.appendChild(clonedMenu);

    // Toggle sidebar
    const toggleBtn = document.querySelector(".navbar-toggle");
    toggleBtn.addEventListener("click", () => {
        clonedMenu.classList.add("open");
        document.body.classList.add("sidebar-open"); // 🔒 Lock scroll + fix overlap
    });

    closeBtn.addEventListener("click", () => {
        clonedMenu.classList.remove("open");
        document.body.classList.remove("sidebar-open"); // 🔓 Restore scroll + reset
    });

    // Handle dropdown functionality
    const dropdowns = clonedMenu.querySelectorAll(".dropdown > a");

    dropdowns.forEach(drop => {
        drop.addEventListener("click", function (e) {
            e.preventDefault();
            const parentLi = this.parentElement;
            parentLi.classList.toggle("open");
        });
    });
});
