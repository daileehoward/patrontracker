/*
Dana Clemmer, Dailee Howard
scripts/register.html
Script for register page for site/app
*/

document.getElementById("manager").addEventListener("click", displayManagerPhone);

function displayManagerPhone() {
    let manager = document.getElementById("manager");
    let managerExtension = document.getElementById("extensionDiv");

    if (manager.checked) {
        managerExtension.classList.remove("d-none");
    } else {
        managerExtension.classList.add("d-none");
    }
}