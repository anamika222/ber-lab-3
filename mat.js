// ====== Age Calculation from Date of Birth ======
const dobInput = document.getElementById("dob");
const ageDisplay = document.getElementById("ageDisplay");

dobInput.addEventListener("change", function () {
  if (!dobInput.value) {
    ageDisplay.textContent = "Age: —";
    return;
  }

  const dob = new Date(dobInput.value);
  const today = new Date();

  let age = today.getFullYear() - dob.getFullYear();
  const monthDiff = today.getMonth() - dob.getMonth();
  const dayDiff = today.getDate() - dob.getDate();

  if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
    age--;
  }

  ageDisplay.textContent = `Age: ${age}`;
});

// ====== Reset Button Functionality ======
document.getElementById("resetBtn").addEventListener("click", function () {
  document.getElementById("matrimonyForm").reset();
  ageDisplay.textContent = "Age: —";
  document.getElementById("formMessage").textContent = "";
});

// ====== Client-side Validation Before Submit ======
document.getElementById("matrimonyForm").addEventListener("submit", function (e) {
  const messageDiv = document.getElementById("formMessage");
  messageDiv.textContent = "";
  messageDiv.style.color = "";

  // Check required fields (extra safety)
  const requiredFields = ["name", "gender", "dob", "phone", "email"];
  for (let field of requiredFields) {
    if (!this.elements[field].value.trim()) {
      e.preventDefault();
      messageDiv.textContent = "Please fill all required fields (*)";
      messageDiv.style.color = "red";
      return;
    }
  }

  // Age must be 18+
  const ageText = ageDisplay.textContent;
  if (ageText === "Age: —") {
    e.preventDefault();
    messageDiv.textContent = "Please select your Date of Birth";
    messageDiv.style.color = "red";
    return;
  }

  const age = parseInt(ageText.replace("Age: ", ""));
  if (age < 18) {
    e.preventDefault();
    messageDiv.textContent = "You must be at least 18 years old to register!";
    messageDiv.style.color = "red";
    return;
  }

  // If everything is okay – show success message (optional)
  // Note: Actual submission will go to PHP
  messageDiv.textContent = "Submitting your profile...";
  messageDiv.style.color = "green";
});