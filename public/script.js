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
