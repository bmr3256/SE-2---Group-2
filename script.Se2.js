function toggleFAQ(element) {
  const answer = element.nextElementSibling;
  const icon = element.querySelector("i");
  const isCurrentlyOpen = answer.classList.contains("show");

  // Close all other FAQs
  document.querySelectorAll(".faq-answer").forEach((item) => {
    if (item !== answer) {
      item.classList.remove("show");
    }
  });

  document.querySelectorAll(".faq-question").forEach((item) => {
    if (item !== element) {
      item.classList.remove("active");
      const itemIcon = item.querySelector("i");
      itemIcon.classList.remove("fa-chevron-up");
      itemIcon.classList.add("fa-chevron-down");
    }
  });

  // Toggle current FAQ
  if (isCurrentlyOpen) {
    answer.classList.remove("show");
    element.classList.remove("active");
    icon.classList.remove("fa-chevron-up");
    icon.classList.add("fa-chevron-down");
  } else {
    answer.classList.add("show");
    element.classList.add("active");
    icon.classList.remove("fa-chevron-down");
    icon.classList.add("fa-chevron-up");
  }
}

// ========================================
// Star Rating System
// ========================================
let selectedRating = 0;

function rateExperience(rating) {
  selectedRating = rating;
  const stars = document.querySelectorAll(".star-icon");
  stars.forEach((star, index) => {
    if (index < rating) {
      star.classList.add("selected");
    } else {
      star.classList.remove("selected");
    }
  });
}

// Add hover preview effect for stars
document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".star-icon");
  const starsContainer = document.querySelector(".rating-stars");

  if (stars.length > 0) {
    stars.forEach((star, index) => {
      // Hover effect - preview the rating
      star.addEventListener("mouseenter", function () {
        stars.forEach((s, i) => {
          if (i <= index) {
            s.style.fill = "var(--orange)";
            s.style.stroke = "var(--orange)";
          } else {
            if (!s.classList.contains("selected")) {
              s.style.fill = "none";
              s.style.stroke = "var(--button-tan)";
            }
          }
        });
      });
    });

    // When mouse leaves the entire star container, restore selected state
    if (starsContainer) {
      starsContainer.addEventListener("mouseleave", function () {
        stars.forEach((s, i) => {
          if (i < selectedRating) {
            s.style.fill = "var(--orange)";
            s.style.stroke = "var(--orange)";
          } else {
            s.style.fill = "none";
            s.style.stroke = "var(--button-tan)";
          }
        });
      });
    }
  }
});

// ========================================
// Cart Management (if needed)
// ========================================
function updateCartBadge() {
  const cartBadge = document.querySelector(".cart-badge");
  const cartCount = parseInt(localStorage.getItem("cartCount")) || 0;
  if (cartBadge) {
    cartBadge.textContent = cartCount;
  }
}

// Update cart badge on page load
document.addEventListener("DOMContentLoaded", function () {
  updateCartBadge();
});

// Add to cart functionality
document
  .querySelectorAll(".btn-add-cart, .btn-add-cart-detail")
  .forEach((button) => {
    button.addEventListener("click", function () {
      let cartCount = parseInt(localStorage.getItem("cartCount")) || 0;
      cartCount++;
      localStorage.setItem("cartCount", cartCount);
      updateCartBadge();

      // Visual feedback
      this.textContent = "Added!";
      this.style.backgroundColor = "#4CAF50";

      setTimeout(() => {
        this.textContent = "Add to Cart";
        this.style.backgroundColor = "";
      }, 2000);
    });
  });
