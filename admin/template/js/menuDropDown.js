let menuItem = document.getElementsByClassName('menu__nav--item');
for (let i = 0; i < menuItem.length; i++) {
  menuItem[i].addEventListener("mouseenter", showSub, false);
  menuItem[i].addEventListener("mouseleave", hideSub, false);
}

function showSub(e) {
  if(this.children.length>1) {
    this.children[1].style.height = "auto";
    this.children[1].style.overflow = "visible";
    this.children[1].style.opacity = "1";
    this.children[1].style.display = "block";
  } else {
    return false;
  }
}

function hideSub(e) {
  if(this.children.length>1) {
    this.children[1].style.height = "0px";
    this.children[1].style.overflow = "hidden";
    this.children[1].style.opacity = "0";
    this.children[1].style.display = "none";
  } else {
    return false;
  }
}
