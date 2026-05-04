(function () {
  // Run the check immediately — blocks rendering via async
  async function checkAdminAuth() {
    try {
      const res = await fetch("admin-check.php", {
        method: "POST",
        credentials: "include", // sends the PHP session cookie
      });

      const data = await res.json();

      if (!data.authorized) {
        window.location.replace("Adminlogin.Se2.html");
      }
    } catch (err) {
      // If the check fails for any reason, deny access
      window.location.replace("Adminlogin.Se2.html");
    }
  }

  // Hide page content while checking, then reveal if authorized
  document.documentElement.style.visibility = "hidden";

  checkAdminAuth().then(() => {
    document.documentElement.style.visibility = "visible";
  });
})();
