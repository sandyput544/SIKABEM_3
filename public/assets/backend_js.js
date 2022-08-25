var sideNavBar = document.querySelector("#leftSideContent");
var toggleSideNav = document.querySelector(".toggle-sidebar");

toggleSideNav.onclick = function () {
  sideNavBar.classList.toggle("toggle-me");
};

function cardLogoPreview() {
  const logo = document.querySelector("#inputFileLogo");
  const imgPreview = document.querySelector(".card-img-preview");

  const fileLogo = new FileReader();
  fileLogo.readAsDataURL(logo.files[0]);

  fileLogo.onload = function (e) {
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
