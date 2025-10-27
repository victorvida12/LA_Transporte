// Apagar lupa com digitação no campo de busca

document.addEventListener("DOMContentLoaded", function() {
  const input = document.querySelector(".search-box input");
  const icon = document.querySelector(".search-box i");

  input.addEventListener("input", function() {
    if (this.value.trim() !== "") {
      icon.style.display = "none"; // esconde a lupa
    } else {
      icon.style.display = "block"; // mostra de novo quando apagar o texto
    }
  });
});