
function showHideSideMenu() {
	const SideMenuOverlay = document.getElementById("menuOverlay");
	const SideMenu = document.getElementById("menuWrapper");
	const SideMenuToggle = document.getElementById("menuToggleButton");
	SideMenuOverlay.classList.toggle("showMenu");
	SideMenu.classList.toggle("showMenu");
	SideMenuToggle.classList.toggle("showMenu");
}