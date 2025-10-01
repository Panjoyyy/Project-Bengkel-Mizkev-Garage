//sidebar expand
const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
});

//navbar fixed
const navbar = document.querySelector(".navbar");
function handleResponsiveNavbar() {
    if (window.innerWidth <= 767) {
        navbar.classList.remove("d-none");
        document.querySelector("#sidebar").classList.add("d-none");
    } else {
        navbar.classList.add("d-none");
        document.querySelector("#sidebar").classList.remove("d-none");
    }
}

handleResponsiveNavbar();

window.addEventListener("resize", handleResponsiveNavbar);

function addQuestion() {
    var questionContainer = document.getElementById("question-container");
    var questionInputContainer = questionContainer.querySelector(
        ".row.question-input"
    );

    var newQuestionInput = document.createElement("div");
    newQuestionInput.classList.add("col-md-10", "mb-3");
    newQuestionInput.innerHTML = `
      <label for="question" class="form-label">Pertanyaan</label>
      <textarea type="text" class="form-control" name="question[]" placeholder="Silahkan Isi Pertanyaan" rows="6" required></textarea>
  `;

    var newMaxPointInput = document.createElement("div");
    newMaxPointInput.classList.add("col-md-2", "mb-3");
    newMaxPointInput.innerHTML = `
      <label for="point" class="form-label">Bobot</label>
      <input type="text" class="form-control" name="max_point[]" placeholder="Bobot" required>
  `;

    questionInputContainer.appendChild(newQuestionInput);
    questionInputContainer.appendChild(newMaxPointInput);
}
