const pre = document.getElementById("matrix");
const originalContent = pre.textContent;
let showingMatrix = false;
let matrixInterval;

function updateMatrix() {
  let newContent = "";
  for (let char of originalContent) {
    if (char.trim() !== "") {
      newContent += Math.random() > 0.5 ? "0" : "1";
    } else {
      newContent += char;
    }
  }
  pre.textContent = newContent;
}

function toggleContent() {
  if (showingMatrix) {
    clearInterval(matrixInterval);
    pre.textContent = originalContent;
  } else {
    updateMatrix();
    matrixInterval = setInterval(updateMatrix, 100);
  }
  showingMatrix = !showingMatrix;
  const randomInterval = Math.random() * 2000 + 777;
  setTimeout(toggleContent, randomInterval);
}

document.addEventListener("DOMContentLoaded", () => {
  document.documentElement.style.scrollBehavior = "smooth";

  let isScrolling;
  window.addEventListener("scroll", () => {
    document.body.classList.add("scrolling");
    clearTimeout(isScrolling);
    isScrolling = setTimeout(() => {
      document.body.classList.remove("scrolling");
    }, 300);
  });

  setTimeout(scrollDownOnePage, 2000);
});

function scrollDownOnePage() {
  const container = document.querySelector(".container");
  container.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.header-content');
  const pages = document.querySelectorAll('.page');
  const container = document.querySelector('.container');

  function updateHeaderBackground() {
    const scrollPosition = container.scrollTop;
    const windowHeight = window.innerHeight;

    pages.forEach(page => {
      const rect = page.getBoundingClientRect();
      if (rect.top <= windowHeight/2 && rect.bottom >= windowHeight/2) {
        const backgroundColor = window.getComputedStyle(page).backgroundColor;
        header.style.backgroundColor = backgroundColor;
      }
    });
  }

  container.addEventListener('scroll', updateHeaderBackground);
  updateHeaderBackground();
});
