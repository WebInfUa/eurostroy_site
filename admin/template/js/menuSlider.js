function isOpenNav() {
  document.getElementById("burgerMenu").style.display = "flex";
}

function isCloseNav() {
  document.getElementById("burgerMenu").style.display = null;
}

window.matchMedia("(min-width: 950px)").addListener(isCloseNav);
