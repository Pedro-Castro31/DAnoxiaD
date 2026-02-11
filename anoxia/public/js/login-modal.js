document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("openLoginModal").addEventListener("click", function() {
        let modal = new bootstrap.Modal(document.getElementById('loginModal'));
        modal.show();
    });

});