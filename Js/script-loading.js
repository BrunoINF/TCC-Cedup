const form = document.getElementById("form");

form.addEventListener("submit", function(e) {
  e.preventDefault();
  showLoader();

  setTimeout(() => {
    form.submit();
  }, 800);
});

function showLoader() {
  document.getElementById("loader").style.display = "flex";
}
