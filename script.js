// Function to toggle the menu visibility on small screens
function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active'); // Add/remove the 'active' class
  }
  
  function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this animal?")) {
        window.location.href = "?delete=" + id;
    }
}
