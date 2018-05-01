
// UPLOAD IMAGE DANS INSCRPTION.HTML
function handle(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById('choose-img');
            img.setAttribute('style', 'background-image:url('+e.target.result+')');
        }
        reader.readAsDataURL(input.files[0]);
        console.log("Image chargé");
    }
};

