var sideNavBar = document.querySelector("#leftSideContent");
var toggleSideNav = document.querySelector(".toggle-sidebar");

toggleSideNav.onclick = function () {
  sideNavBar.classList.toggle("toggle-me");
};

function imgPreview() {
  const foto = document.querySelector("#foto");
  const imgPreview = document.querySelector(".img-preview");

  const fileFoto = new FileReader();
  fileFoto.readAsDataURL(foto.files[0]);

  fileFoto.onload = function (e) {
    imgPreview.src = e.target.result;
  };
}

function cardImgPreview() {
  const img = document.querySelector("#inputImage1","#inputImage2","#inputImage3");
  const imgPreview = document.querySelector(".card-img-preview");

  const fileImage = new FileReader();
  fileImage.readAsDataURL(img.files[0]);

  fileImage.onload = function (e) {
    imgPreview.src = e.target.result;
  };
}
