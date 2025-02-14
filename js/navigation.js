/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

const centerSubnav = () => {
  const lihaschildren = document.querySelectorAll(
    "#primary-menu > .menu-item-has-children:not(.multiplecols)"
  );
  lihaschildren.forEach(function (liMenuItem) {
    const subMenu = liMenuItem.querySelector(":scope > .sub-menu");
    const subMenuWidth = subMenu.offsetWidth;
    const liMenuItemWidth = liMenuItem.offsetWidth;
    const centerOfSubmenu = (subMenuWidth - liMenuItemWidth) / 2;
    console.log(centerOfSubmenu);
    console.log(subMenu);
    subMenu.style.marginLeft = "-" + centerOfSubmenu + "px";
  });
};

const outsideLink = () => {
    const quicklinks = document.querySelector("#quicklinks");
  
    if (quicklinks) {
      // Sélectionne toutes les balises <figure> dans #quicklinks
      const figures = quicklinks.querySelectorAll("figure");
  
      figures.forEach((figure) => {
        const link = figure.querySelector("a"); // Sélectionne le lien <a> s'il existe
        
        if (link) {
          // Récupère l'URL du lien
          const href = link.getAttribute("href");
          
          // Crée un nouveau lien qui enveloppera la figure
          const wrapperLink = document.createElement("a");
          wrapperLink.href = href;
          
          // Remplace la figure par le nouveau lien et met la figure à l'intérieur
          figure.parentNode.insertBefore(wrapperLink, figure);
          wrapperLink.appendChild(figure);
          
          // Supprime l'ancien lien
          link.replaceWith(link.firstChild);
        }
      });
    }
};

const navigation = document.getElementById("site-navigation");
const menubtn = navigation.querySelector(".menu-toggle");
const submenubtn = navigation.querySelectorAll(".menu-item-has-children");
const submenus = navigation.querySelectorAll("#primary-menu > li > .sub-menu");
const menu = navigation.getElementsByTagName("ul")[0];

if (!menu.classList.contains("nav-menu")) {
  menu.classList.add("nav-menu");
}

const links = menu.getElementsByTagName("a");

const linksWithChildren = menu.querySelectorAll(
  ".menu-item-has-children > a, .page_item_has_children > a"
);

for (const link of links) {
  link.addEventListener("focus", toggleFocus, true);
  link.addEventListener("blur", toggleFocus, true);
  link.addEventListener("click", toggleFocus, true);
}

for (const link of linksWithChildren) {
  link.addEventListener("touchstart", toggleFocus, false);
}

function toggleFocus() {
  console.log(event.type);
  if (event.type === "focus" || event.type === "blur" || event.type === "click") {
    let self = this;
    submenubtn.forEach(function (submenubtn) {
      submenubtn.classList.remove("focus");
    });
    while (!self.classList.contains("nav-menu")) {
      if (self.tagName.toLowerCase() === "li") {
        self.classList.add("focus");
      }
      self = self.parentNode;
    }
    const currentSubMenu = this.parentNode.querySelector(":scope > .sub-menu");
	if (currentSubMenu instanceof Element) {
		submenus.forEach(function (submenu) {
			submenu.classList.remove("edge");
		});
		var rect = currentSubMenu.getBoundingClientRect();

		var off = {
		top: rect.top + window.scrollY,
		left: rect.left + window.scrollX,
		};
		const l = off.left;
		const w = currentSubMenu.offsetWidth;
		const docW = document.querySelector("#masthead").offsetWidth;

		const isEntirelyVisible = l + w <= docW;

		if (!isEntirelyVisible) {
		currentSubMenu.classList.add("edge");
		}
	}
  }

  if (event.type === "touchstart" ) {
    console.log(event.type);
    const menuItem = this.parentNode;
    event.preventDefault();
    for (const link of menuItem.parentNode.children) {
      if (menuItem !== link) {
        link.classList.remove("focus");
      }
    }
    menuItem.classList.toggle("focus");
  }
}

// mobile nav

const responsive = (navigation) => {
  if (navigation.className === "main-navigation") {
    navigation.className += " responsive";
    document.querySelector("body").style.overflow = "hidden";
  } else {
    navigation.className = "main-navigation";
    document.querySelector("body").style.overflow = "auto";
  }
};
menubtn.addEventListener("click", () => {
  responsive(navigation);
});

window.addEventListener("load", () => {
  outsideLink();
  centerSubnav();
});
window.addEventListener("resize", () => {
  centerSubnav();
  submenubtn.forEach(function (submenubtn) {
    submenubtn.classList.remove("focus");
  });
});
   